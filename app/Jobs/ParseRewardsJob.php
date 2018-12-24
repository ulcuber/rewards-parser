<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client;

use App\Models\Reward;

class ParseRewardsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $client;

    public function handle()
    {
        $this->createClient();
        $this->createRewards();
    }

    private function createClient()
    {
        $this->client = new Client(config('campaign'));
    }

    private function createRewards()
    {
        $rewards = $this->getRewards();
        foreach ($rewards as $item) {
            Reward::firstOrCreate([
                'id' => $item['id'],
            ], [
                'name' => $item['name'],
                'amount' => $item['amount'],
            ]);
        }
    }

    private function getRewards(): array
    {
        $response = $this->client->get('rewards');
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Not 200 when parsing rewards');
        }
        $body = (string) $response->getBody();
        return json_decode($body, true)['data'];
    }
}
