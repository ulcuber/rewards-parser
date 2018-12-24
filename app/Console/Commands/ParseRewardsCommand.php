<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\ParseRewardsJob;

class ParseRewardsCommand extends Command
{
    protected $signature = 'parse:rewards';
    protected $description = 'Parse rewards';

    public function handle()
    {
        ParseRewardsJob::dispatch();
    }
}
