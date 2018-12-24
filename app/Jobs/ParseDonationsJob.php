<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Cache;
use GuzzleHttp\Client;

use App\Events\RewardAmountUpdatedEvent;

use App\Models\Donation;

class ParseDonationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $next;
    private $client;

    public function __construct(string $url = null, bool $next = false)
    {
        info("Parsing url: {$url}, $next");
        $this->url = $url;
        $this->next = $next;
    }

    public function handle()
    {
        $this->createClient();
        $this->parseDonations();
    }

    private function createClient(): void
    {
        $this->client = new Client(config('campaign'));
    }

    private function parseDonations(): void
    {
        $donationsArray = $this->getDonationsArray();
        $donations = array_filter($donationsArray['data'], function ($item) {
            return isset($item['id'])
                && isset($item['amount']);
        });
        $this->createdonations($donations);
        if ($this->next) {
            $this->dispatchNextJob($donationsArray['links']);
        } else {
            $this->dispatchPrevJob($donationsArray['links']);
        }
    }

    private function dispatchNextJob(array $links)
    {
        if ($next = $links['next']) {
            Cache::forever('donations-last-url', $next);
            static::dispatch($next, true);
        }
    }

    private function dispatchPrevJob(array $links)
    {
        if ($prev = $links['prev']) {
            static::dispatch($prev);
        } else {
            info("Parsing to prev ended");
        }
        if (!$this->url) {
            $this->dispatchNextJob($links);
        }
    }

    private function createDonations(array $items): void
    {
        foreach ($items as $item) {
            $rewardId = $item['rewardId'] ?? null;
            $donation = Donation::firstOrCreate([
                'id' => $item['id'],
            ], [
                'amount' => $item['amount'],
                'reward_id' => $rewardId,
            ]);
            if ($rewardId) {
                RewardAmountUpdatedEvent::dispatch($donation);
            }
        }
    }

    private function getDonationsArray(): array
    {
        $response = $this->client->get($this->url ?: 'donations?count=100');
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Not 200 when parsing rewards');
        }
        $body = (string) $response->getBody();
        return json_decode($body, true);
    }
}
