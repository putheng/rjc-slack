<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProductionMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate production application';

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
        config('database.default', 'pgsql_live');

        $artisan  = Artisan::call('migrate');

        dd($artisan);
    }
}
