<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Reward;

class RewardsIndexTest extends TestCase
{
    use DatabaseTransactions;

    public function testRewards()
    {
        $response = $this->makeRewardsRequest();
        $this->assertResponse($response);
    }

    private function makeRewardsRequest(): TestResponse
    {
        return $this->json('GET', "/api/rewards");
    }

    private function assertResponse(TestResponse $response): void
    {
        $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'name',
                    'amount',
                    'collected',
                ]
            ]
        ]);

        collect($response->json('data'))
        ->each(function (array $item) {
            $reward = Reward::find($item['id']);
            $collected = $reward->donations()->sum('amount');
            $this->assertEquals($item['collected'], $collected);
        });
    }
}
