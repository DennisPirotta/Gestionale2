<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\ModelFlags\Models\Flag;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ClearLocationFlag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locations:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all location flag daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        Flag::where('name','location')->delete();
        return CommandAlias::SUCCESS;
    }
}
