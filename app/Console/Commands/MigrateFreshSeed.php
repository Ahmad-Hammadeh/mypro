<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateFreshSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mfs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Fresh And Database Seed Commands Abbreviation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Artisan::call('migrate:fresh');
        \Artisan::call('db:seed');
    }
}
