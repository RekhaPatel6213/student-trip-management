<?php

namespace App\Services;

use App\Repositories\TripRepository;
use App\Models\Trip;
use App\Models\Schedule;
use App\Models\TripInvite;
use Carbon\Carbon;
use App\Helpers\Helper;

class TripService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new TripRepository();
    }

    public function list(string $type)
    {
        return $this->repository->getQueryBuilder(null, 'start_date', 'asc')
                ->where('type', $type)
                ->get();
    }

	public function create(array $requestData)
    {
        $requestData['end_date'] = $requestData['start_date'];
        if($requestData['week_day'] !== null) {
            $requestData['end_date'] = Carbon::parse($requestData['start_date'])->addDays(($requestData['week_day']-1))->format('Y-m-d');
        } else {
            $requestData['week_day'] = 1;
        }
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, Trip $trip)
    {
        $requestData['end_date'] = $requestData['start_date'];
        if($requestData['week_day'] !== null) {
            $requestData['end_date'] = Carbon::parse($requestData['start_date'])->addDays(($requestData['week_day']-1))->format('Y-m-d');
        } else {
            $requestData['week_day'] = 1;
        }

        return $this->repository->store($requestData, $trip);
    }

    public function bulkDelete(array $requestData)
    {
        return $this->repository->bulkDelete($requestData);
    }


    public function scheduleTrips(string $type, string $village)
    {
        $dates = Helper::getCurentYearDates( Carbon::now()->format('Y-m-d'));

        request()->session()->forget(['billFileRoute', 'allClasses']);

        $schedules = Schedule::with([
                                    'school' => function($query) {
                                        $query->select('id','name','district_id')
                                            ->with(['district:id,name']);
                                    }
                            ])
                            ->withCount('studentInfo')
                            ->when(($village !== null && $village === 'eagle_point'), function($query) use($type){
                                $query->where('is_eagle_point', Schedule::YES);
                            })
                            //->where('type', strtoupper($type))
                            ->whereBetween('trip_date', [$dates['startDate'], $dates['endDate']])
                            ->get();
        //dd($schedules);
        $daySchedules = $schedules->where('type', Schedule::DAY);
        $dayPending = $daySchedules->where('status', Schedule::PENDING);
        $dayConfirmed = $daySchedules->where('status', Schedule::CONFIRMED);
        //$dayRegistered = $daySchedules->where('status', Schedule::REGISTERED);
        $dayTotalPendingCount = $dayPending->count();
        $dayTotalConfirmedCount = $dayConfirmed->count();
        //$dayTotalRegisteredCount = $dayRegistered->count();
        $daySchoolIds = array_unique(data_get($daySchedules, '*.school_id'));
        
        $weekSchedules = $schedules->where('type', Schedule::WEEK);
        $weekPending = $weekSchedules->where('status', Schedule::PENDING);
        $weekConfirmed = $weekSchedules->where('status', Schedule::CONFIRMED);
        $weekRegistered = $weekSchedules->where('status', Schedule::REGISTERED);
        $weekTotalPendingCount = $weekPending->count();
        $weekTotalConfirmedCount = $weekConfirmed->count();
        $weekTotalRegisteredCount = $weekRegistered->count();
        $weekSchoolIds = array_unique(data_get($weekSchedules, '*.school_id'));


        $dayOpenCount = $weekOpenCount = 0;

        $dateS = Carbon::now()->startOfMonth();
        $dateE = Carbon::now()->endOfMonth()->addMonth(1);
        $currentMonthDates = Schedule::select('trip_date','status')->where('type', strtoupper($type))->whereBetween('trip_date',[$dateS,$dateE])->get();

        $dayPendingCount = $weekPendingCount = $currentMonthDates->where('status', Schedule::PENDING)->count();
        $dayConfirmedCount = $weekConfirmedCount = $currentMonthDates->where('status', Schedule::CONFIRMED)->count();
        $dayRegisteredCount = $weekRegisteredCount = $currentMonthDates->where('status', Schedule::REGISTERED)->count();
        
        $dateCount = count(array_unique(data_get($currentMonthDates, '*.trip_date')));
        $totalDays = $dateE->diffInDays($dateS);
        $daysForExtraCoding = $dateS->diffInDaysFiltered(function(Carbon $date) {
           return $date->isWeekend();
        }, $dateE);
        $weekOpenCount = $dayOpenCount = ($totalDays - $dateCount - $daysForExtraCoding);
        
        return [
            'dayPending' => $dayPending,
            'dayConfirmed' => $dayConfirmed,
            //'dayRegistered' => $dayRegistered,
            'dayTotalPendingCount' => $dayTotalPendingCount,
            'dayTotalConfirmedCount' => $dayTotalConfirmedCount,
            //'dayTotalRegisteredCount' => $dayTotalRegisteredCount,
            'dayOpenCount' => $dayOpenCount,
            'dayPendingCount' => $dayPendingCount,
            'dayConfirmedCount' => $dayConfirmedCount,
            //'dayRegisteredCount' => $dayRegisteredCount,
            'daySchoolIds' => $daySchoolIds,
            'weekPending' => $weekPending,
            'weekConfirmed' => $weekConfirmed,
            'weekRegistered' => $weekRegistered,
            'weekTotalPendingCount' => $weekTotalPendingCount,
            'weekTotalConfirmedCount' => $weekTotalConfirmedCount,
            'weekTotalRegisteredCount' => $weekTotalRegisteredCount,
            'weekOpenCount' => $weekOpenCount,
            'weekPendingCount' => $weekPendingCount,
            'weekConfirmedCount' => $weekConfirmedCount,
            'weekRegisteredCount' => $weekRegisteredCount,
            'weekSchoolIds' => $weekSchoolIds,
            'totalCount' => $schedules->count(),
        ];
    }

    public function getTripInvites(string $village)
    {
        $tripInvites = TripInvite::village($village)->where('status', '!=', TripInvite::COMPLETED)->with(['school:id,name'])->orderBy('id','asc')->get();
        $weekInvites = $tripInvites->where('type', TripInvite::WEEK);
        $dayInvites = $tripInvites->where('type', TripInvite::DAY);

        return [
            'weekInvites' => $weekInvites,
            'dayInvites' => $dayInvites,
        ];
    }
}