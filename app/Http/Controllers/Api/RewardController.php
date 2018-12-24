<?php

namespace App\Http\Controllers\Api;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RewardResource;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::withCollected()->get();
        return RewardResource::collection($rewards);
    }
}
