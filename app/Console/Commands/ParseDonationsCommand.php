<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\ParseDonationsJob;

class ParseDonationsCommand extends Command
{
    protected $signature = 'parse:donations {--from=}';
    protected $description = 'Parse donations';

    public function handle()
    {
        ParseDonationsJob::dispatch($this->option('from'));
    }
}
