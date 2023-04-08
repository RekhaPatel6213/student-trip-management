<?php
namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Cabin;
use App\Models\TrailGroup;
use File;

class Helper
{

	public static function DateFormate($date, $format)
    {
        return Carbon::parse($date)->format($format);
    }

    public static function DbDateFormate($date)
    {
        return Carbon::createFromFormat(config("constants.DATE_FORMATE"), $date)->format(config("constants.DB_DATE_FORMATE"));
    }

    public static function getAllCabins()
    {
        $yes = Cabin::YES;
        $no = Cabin::NO;
        $femail = Cabin::FEMALE;
        $male = Cabin::MALE;

        $cabins = Cabin::select('name', 'id', 'gender', 'is_eagle_point')->get();
        $bearGirlCabins = $cabins->where('is_eagle_point', $no)->where('gender', $femail)->pluck('name', 'id');
        $bearBoyCabins = $cabins->where('is_eagle_point', $no)->where('gender', $male)->pluck('name', 'id');
        $eagelGirlCabins = $cabins->where('is_eagle_point', $yes)->where('gender', $femail)->pluck('name', 'id');
        $eagelBoyCabins = $cabins->where('is_eagle_point', $yes)->where('gender', $male)->pluck('name', 'id');

        return [
            'bearGirlCabins' => $bearGirlCabins,
            'bearBoyCabins' => $bearBoyCabins,
            'eagelGirlCabins' => $eagelGirlCabins,
            'eagelBoyCabins' => $eagelBoyCabins,
        ];
    }

    public static function getAllTrailGroups()
    {
        $trailgroupList = TrailGroup::get();
        $trailgroups['Bear_Creek'] = $trailgroupList->where('is_eagle_point', TrailGroup::NO)->pluck('name', 'id');
        $trailgroups['Eagle_Point'] = $trailgroupList->where('is_eagle_point', TrailGroup::YES)->pluck('name', 'id');
        return $trailgroups;
    }

    public static function getCurentYearDates($date)
    {
        $currentYear = Carbon::parse($date)->format('Y');
        $currentMonth = Carbon::parse($date)->format('m');

        if($currentMonth >= 1 && $currentMonth <= 6){
            $startDate = ($currentYear - 1).'-06-01';
            $endDate = $currentYear.'-05-31';
        } else {
            $startDate = $currentYear.'-06-01';
            $endDate = ($currentYear + 1).'-05-31';
        }

        return ['startDate' => $startDate, 'endDate' => $endDate];
    }

    public static function getCurentYearWeeks()
    {
        $today = Carbon::now()->format('Y-m-d');
        $dates = self::getCurentYearDates($today);
        $startTime = strtotime($dates['startDate']);
        $endTime = strtotime($dates['endDate']);
        $weeks = array();

        while ($startTime < $endTime) {
            $startDate = date(config('constants.DATE_FORMATE'), $startTime);
            $weekStartDate = Carbon::parse($startDate)->startOfWeek()->format(config('constants.DATE_FORMATE'));
            $weekEndDate = Carbon::parse($startDate)->startOfWeek()->addDays(4)->format(config('constants.DATE_FORMATE'));
            $weeks[date('W#Y', $startTime)] = ['start' => $weekStartDate, 'end' => $weekEndDate]; 
            $startTime += strtotime('+1 week', 0);
        }
        return $weeks;
    }
    
    public static function createFolder($folderName)
    {
        $path = storage_path().'/app/public/'.$folderName;
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        return $path;
    }
}