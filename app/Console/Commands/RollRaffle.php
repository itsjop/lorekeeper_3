<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\RaffleManager;
use App\Models\Raffle\Raffle;
use Carbon\Carbon;

class RollRaffle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roll-raffle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rolls any pending open raffles that are past their end at date. This will not roll any raffles without an end at time.';

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
        $raffles = Raffle::where('is_active', 1)->where('end_at', '<', Carbon::now())->where('roll_on_end', 1)->get();
        $service = new RaffleManager;
        foreach ($raffles as $raffle) {
            $service->rollRaffle($raffle);
        }
    }
}
