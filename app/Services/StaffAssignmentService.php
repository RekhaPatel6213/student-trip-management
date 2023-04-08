<?php

namespace App\Services;

use App\Repositories\StaffAssignmentRepository;
use App\Models\StaffAssignment;
use App\Models\Schedule;
use App\Models\Work;
use App\Helpers\Helper;
use Carbon\Carbon;
use PDF;
use DB;
use Illuminate\Support\Arr;

class StaffAssignmentService
{
	protected $repository;

    public function __construct()
    {
        $this->repository = new StaffAssignmentRepository();
    }

    public function list()
    {
        $assignments = $this->repository->getQueryBuilder(null, 'trip_date', 'asc')
                            ->with(['user:id,name', 'work:id,name'])
                            ->get();

        $assignmentArray = [];
        if($assignments){
            foreach($assignments as $assignment){
                $assignmentArray[$assignment->trip_date][] = ['user' => $assignment->user->name, 'work' => $assignment->work->name] ;
            }
        }
        return $assignmentArray;
    }

	public function store(array $requestData)
    {
        
        $tripDate = \Carbon\Carbon::create($requestData['trip_date']);
        $userIds = $requestData['user_id'];
        $allWorkId = [];

        if($userIds) {
            $i=0;
            foreach($userIds as $workId => $userId) {
                if($userId !== null){
                    $i++;
                    $allWorkId[] = $workId;
                    StaffAssignment::updateOrCreate(
                        [
                            'trip_date' => $tripDate,
                            'work_id' => $workId,
                        ],
                        [
                            'trip_date' => $tripDate,
                            'user_id' => $userId,
                            'work_id' => $workId,
                            'notes' =>  $i === 1 ? $requestData['notes'] : null
                        ]
                    );
                }
            }
            StaffAssignment::where('trip_date',$tripDate)->whereNotIn('work_id', $allWorkId)->delete();
        }
    }

    public function checkSchedule(array $requestData)
    {
    	$tripDate = Carbon::parse($requestData['trip_date'])->format(config('constants.DB_DATE_FORMATE'));
    	$scheduleCount = Schedule::where('trip_date', $tripDate)->count();
    	$assignments = StaffAssignment::select('user_id','work_id')->where('trip_date', $tripDate)->get();

    	return ['scheduleCount' => $scheduleCount, 'assignments' => $assignments ];
    }

    public function getAssignments(string $date)
    {
        $tripDate = Carbon::parse(($date))->format(config('constants.DB_DATE_FORMATE'));
        return $staffAssignment = StaffAssignment::where('trip_date', $tripDate)->get();
    }

    public function generateStaffAssignmentPDF(string $type, string $date)
    {
        $type = base64_decode($type);
        $date = base64_decode($date);
        $tripDate = Carbon::parse($date)->format(config('constants.DB_DATE_FORMATE'));
        $assignments = StaffAssignment::select('user_id','work_id','notes')
                                ->with(['user:id,name'])
                                ->where('trip_date', $tripDate)
                                ->get();
        $userWorkIds = $assignments->pluck('user_id','work_id')->toArray();
        $users = Arr::pluck(data_get($assignments, '*.user'), 'name','id');
        $notes = Arr::collapse(array_filter(data_get($assignments, '*.notes')));
        $works = Work::select('id','name','is_eagle_point')->staff()->get();
        $schedules = $this->getScheduleByDate($tripDate);
        //return view('staffAssignments.staffAssignmentPDF', compact('date', 'userWorkIds', 'users', 'notes', 'works', 'schedules','type'));
        $fileName = 'Staff_Assignment_'.str_replace('/','_',$date).'.PDF';
        $pdf = PDF::loadView('staffAssignments.staffAssignmentPDF', compact('date', 'userWorkIds', 'users', 'notes', 'works', 'schedules' ,'type'));
        return $pdf->download($fileName);
    }

    public function downloadBulletinPDF(string $date)
    {
        $date = base64_decode($date);
        $tripDate = Carbon::parse($date)->format(config('constants.DB_DATE_FORMATE'));
        $schedules = $this->getScheduleByDate($tripDate, Schedule::WEEK);
        $scheduleCount = $schedules->count();
        if($scheduleCount > 0){
            //return view('staffAssignments.sciconBulletin', compact('date', 'schedules'));
            $fileName = 'SCICON_Bulletin_'.str_replace('/','_',$date).'_'.date('mdYHis').'.PDF';
            $pdf = PDF::loadView('staffAssignments.sciconBulletin', compact('date', 'schedules'));
            $path = Helper::createFolder('sciconBulletin');
            $filepath = $path .'/'. $fileName;
            $pdf->save($filepath);
            $fileRoute = route('download','public/sciconBulletin/'.$fileName);
        }
        return ['filePath' => $fileRoute??null, 'schedules' => $scheduleCount];
    }

    public function getScheduleByDate(string $tripDate, string $type = null)
    {
        $tripEndDate = Carbon::parse($tripDate)->endOfWeek()->format('Y-m-d');

        return Schedule::select('school_id', 'trip_date', 'type', DB::raw("COUNT(id) as countId"), DB::raw("SUM(students) as students"), DB::raw("GROUP_CONCAT(teacher) as teachers"))
                                ->when($type !== null, function($query) use($type) {
                                    $query->where('type', $type);
                                })
                                ->whereBetween('trip_date', [$tripDate, $tripEndDate])
                                ->with(['school:id,name'])
                                ->groupBy(['trip_date', 'school_id','type'])
                                ->get();
    }
}