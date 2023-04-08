<?php

namespace App\Services;

use App\Repositories\CabinRepository;
use App\Models\Cabin;
use App\Models\Schedule;
use App\Models\ScheduleStudent;
use Carbon\Carbon;

class CabinService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new CabinRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, Cabin $cabin)
    {
        return $this->repository->store($requestData, $cabin);
    }

    public function bulkDelete(array $requestData)
    {
        return $this->repository->bulkDelete($requestData);
    }

    public function getCabinAssignmentInfo(string $startDate, string $endDate)
    {
        //echo $startDate.'/'.$endDate;
        $schedules = Schedule::where('type', Schedule::WEEK)
                    ->where('status', Schedule::REGISTERED)
                    ->whereBetween('trip_date', [Carbon::create($startDate)->format('Y-m-d'), Carbon::create($endDate)->format('Y-m-d')])
                    ->with(['school:id,name', 'studentInfo.cabin'])
                    /*->withCount(['studentInfo' => function($query) {
                        $query->whereNotNull('cabin_id');
                    }])*/
                    ->orderBy('trip_date','asc')->get();
        //dd($schedules->toArray());
        //$studentCount = $schedules->sum('students');
        //$assignStudent = $schedules->sum('student_info_count');

        $cabinIds = data_get($schedules, '*.studentInfo.*.cabin.id');
        //$cabinIds = array_filter(data_get($schedules, '*.studentInfo.*.cabin.id'));
        $studentCount = count($cabinIds);
        $assignStudent = count(array_filter($cabinIds));

        $cabins = Cabin::select('id','name','gender','eligible_student','block_week','is_disability')->with([
            'students' => function($query) {
                $query->orderBy('schedule_id','asc');
            }
        ])->get();

        return [
            'studentCount' => $studentCount,
            'assignStudent' => $assignStudent,
            'notAssignStudent' => $studentCount - $assignStudent,
            'scheduleCount' => $schedules->count(),
            'schedules' => $schedules,
            'cabinIds' => $cabinIds,
            'allCabins' => $cabins,
            'cabins' => ['girls' => $cabins->where('gender', Cabin::FEMALE), 'boys' => $cabins->where('gender', Cabin::MALE)],
        ];
    }

    public function blockCabin(array $requestData)
    {
        $cabin = Cabin::find($requestData['cabinId']);
        $cabin->block_week = $cabin->block_week !== null ? array_merge($cabin->block_week, [$requestData['blockWeek']]) : [$requestData['blockWeek']];
        $cabin->save();
        return null;
    }

    public function autoSortCabin(array $requestData)
    {
        $dates = explode(' - ', $requestData['dates']);
        $week = $requestData['week'];

        $blockCabinIds = Cabin::whereJsonContains('block_week', $week)->pluck('id');
        $cabins = Cabin::select('id','name','gender','eligible_student','is_disability')
                        ->whereNotIn('id', $blockCabinIds)
                        ->withCount('students')
                        ->get();
        $boysCabin = array_values($cabins->where('gender', Cabin::MALE)->toArray());
        $girlsCabin = array_values($cabins->where('gender', Cabin::FEMALE)->toArray());

        $schedules = Schedule::where('type', Schedule::WEEK)
                    ->where('status', Schedule::REGISTERED)
                    ->whereBetween('trip_date', [Carbon::create($dates[0])->format('Y-m-d'), Carbon::create($dates[1])->format('Y-m-d')])
                    ->with([
                        'studentInfo' => function($query) {
                            $query->select('id','schedule_id', 'is_disability','teacher_cabin_id','cabin_id','gender','student_name')
                            ->with(['cabin'])->orderBy('teacher_cabin_id','desc');
                        }])
                    ->orderBy('trip_date','asc')
                    ->get();

        $boyCabinId = $girlCabinId = 0;
        $studentArray = [];

        if(count($schedules) > 0) {
            foreach($schedules as $schedule) {
               $assignCabin = [];
                if(count($schedule->studentInfo) > 0) {
                    $cabinGroups = $schedule->studentInfo->where('teacher_cabin_id', '!=', null)->pluck('teacher_cabin_id', 'id');
                    foreach($schedule->studentInfo as $skey => $student) {

                        if($student->cabin_id !== null){
                            $assignCabin[$student->cabin_id][] = $student->id;
                        } else {
                            $cabinGroups = $schedule->studentInfo->where('teacher_cabin_id', '!=', null)->where('teacher_cabin_id', $student->teacher_cabin_id)->pluck('teacher_cabin_id', 'id')->toArray();


                            if($student->gender === ScheduleStudent::MALE){
                                list($assignCabin, $boyCabinId, $cabinId) = $this->getCabin($boysCabin, $boyCabinId, $assignCabin, $student->id, $student->is_disability, $cabinGroups);
                            } else {
                                list($assignCabin, $girlCabinId, $cabinId) = $this->getCabin($girlsCabin, $girlCabinId, $assignCabin, $student->id, $student->is_disability, $cabinGroups);
                            }

                            $studentArray[] = [
                                'id' => $student->id,
                                'schedule_id' => $student->schedule_id,
                                'student_name' => $student->student_name,
                                'cabin_id' => $cabinId,
                            ];
                        }
                    }
                }
            }
        }
        ScheduleStudent::upsert($studentArray, ['id','student_name','schedule_id','cabin_id'], ['id','cabin_id']);
        return null;
    }

    public function getCabin($cabins, $cabinId, $assignCabin, $studentId, $isDisability, $cabinGroups)
    {
        $assignCabinIdNew = null;
        if($isDisability === ScheduleStudent::YES){
            $cabin = $cabins[array_search(Cabin::YES, array_column($cabins, 'is_disability'))];
            $assignCabin[$cabin['id']][] = $studentId;
            return [$assignCabin, $cabinId, $cabin['id']??$assignCabinIdNew];
        } 

        if(count($assignCabin) > 0){
            foreach($assignCabin as $assignCabinId => $assignStudents){
                if(in_array($studentId, $assignStudents)){
                    return [$assignCabin, $cabinId, $assignCabinId];
                }
            }
        }
        
        if(array_key_exists($cabinId, $cabins)){
            $cabin = $cabins[$cabinId];
            $teacherCabin = $cabinGroups[$studentId]??null;

            if($teacherCabin !== null && array_key_exists($studentId, $cabinGroups)){
                $cabinCount = count($cabinGroups);
                $cabinAssign = isset($assignCabin[$cabin['id']]) ? count($assignCabin[$cabin['id']]) : 0;
                $cabinEligible = $cabin['eligible_student'];

                if(($cabinEligible - $cabinAssign) >= $cabinCount ){
                    foreach($cabinGroups as $student => $group){
                        $assignCabin[$cabin['id']][] = $student;
                    }
                }
            }

            if($cabin['students_count'] >= $cabin['eligible_student']){
                $cabinId++;
                return $this->getCabin($cabins, $cabinId, $assignCabin, $studentId, $isDisability, $cabinGroups); 
            } elseif(isset($assignCabin[$cabin['id']]) && count($assignCabin[$cabin['id']]) === 3){
                $cabinId++;
                return $this->getCabin($cabins, $cabinId, $assignCabin, $studentId, $isDisability, $cabinGroups);

            } elseif(isset($assignCabin[$cabin['id']]) && $cabin['eligible_student'] <= count($assignCabin[$cabin['id']]) ){
                $cabinId++;
                return $this->getCabin($cabins, $cabinId, $assignCabin, $studentId, $isDisability, $cabinGroups);
            } else {
                $assignCabin[$cabin['id']][] = $studentId;
                $assignCabinIdNew = $cabin['id'];
                $cabinId++;
            }
        } else {
            $cabinId = 0;
            return $this->getCabin($cabins, $cabinId, $assignCabin, $studentId, $isDisability, $cabinGroups);
        }
        return [$assignCabin, $cabinId, $cabin['id']??$assignCabinIdNew];
    }

    public function studentDetail(int $studentId)
    {
       return ScheduleStudent::with([
                'schedule' => function($query) {
                    $query->select('id','school_id','teacher')
                    ->with(['school:id,name']);
                }
            ])->find($studentId);
    }

    public function studentUpdate(int $studentId, array $requestData)
    {
        $student = ScheduleStudent::find($studentId);
        $student->student_name = ucwords($requestData['first_name'].' '.$requestData['last_name']);
        $student->first_name = ucfirst($requestData['first_name']);
        $student->last_name = ucfirst($requestData['last_name']);
        $student->gender = $requestData['gender'];
        $student->is_disability = $requestData['disability']??ScheduleStudent::NO;
        $student->teacher_cabin_id = $requestData['cabin_id'];
        $student->note = $requestData['note'];

        if($student->gender !== $requestData['gender'] || $student->teacher_cabin_id !== $requestData['cabin_id'] || $student->disability !== $requestData['disability']){

            $blockCabinIds = Cabin::whereJsonContains('block_week', $requestData['cutrrentWeek'])->pluck('id');
            $cabins = Cabin::select('id','name','gender','eligible_student','is_disability')
                            ->whereNotIn('id', $blockCabinIds)
                            ->withCount('students')
                            ->where('gender', $requestData['gender'])
                            ->get();
           
            if($student->teacher_cabin_id !== null){
                $cabinGroups = ScheduleStudent::where('schedule_id', $student->schedule_id)->where('teacher_cabin_id', '!=', null)->where('teacher_cabin_id', $requestData['cabin_id'])->where('id','!=', $student->id)->get();
                if(count($cabinGroups) > 0 ){
                    $student->cabin_id = $cabinGroups->first()->cabin_id;
                }
            } /*elseif($student->is_disability === ScheduleStudent::YES){
                $student->cabin_id = $cabins->where('is_disability', Cabin::YES)->first()->id;
            }*/
             else {
                $cabinId = 0;
                $assignCabin = [];
                
                list($assignCabin, $cabinId, $updateCabinId) = $this->getCabin($cabins->toArray(), $cabinId, $assignCabin, $studentId, $student->is_disability, []);
                $student->cabin_id = $updateCabinId;
            }
        }

        $student->save();

        if(isset($requestData['teacher'])){
            $student->schedule->teacher = $requestData['teacher'];
            $student->schedule->save();
        }
    }

    public function updateCabin(array $requestData)
    {
        $student = ScheduleStudent::find($requestData['student_id']);
        if(in_array($requestData['type'], ['disability', 'gender', 'normal'])){
            $student->cabin_id = $requestData['cabin_id'];
        }
        $student->save();
    }
}