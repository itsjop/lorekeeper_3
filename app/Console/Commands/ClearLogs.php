<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ClearLogs extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the default laravel logs folder.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
      Artisan::command('logs:clear', function() {

        exec('rm -f ' . storage_path('logs/*.log'));

        exec('rm -f ' . base_path('*.log'));

        $this->comment('Logs have been cleared!');

    })->describe('Clear log files');
    }
}
