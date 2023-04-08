<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;
use Carbon\Carbon;
use DB;

class UpdateTripStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trip:update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Day/Week trip status update.';

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
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $mondayDate = $now->startOfWeek()->format('Y-m-d');
        $tuesdayDate = $now->startOfWeek()->addDay()->format('Y-m-d');

        //Complete Trip
        $trips = Trip::where('end_date', '<=', $now)
                    ->whereIn('status',[Trip::PENDING, Trip::ACTIVE])
                    ->whereNotNull('end_date')
                    ->update(['status' => Trip::COMPLETED]);

        //Active Trip
        $trips = Trip::whereBetween('start_date', [$mondayDate, $tuesdayDate])
                    ->where('status', Trip::PENDING)
                    ->update(['status' => Trip::ACTIVE]);
    }
}
