<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\ScheduleStudent;
use App\Models\EmailTemplate;
use App\Models\MealFee;
use App\Helpers\Helper;
use Carbon\Carbon;
use PDF;
use App\Traits\MailTrait;

class ScheduleService
{
	use MailTrait;

	public function tripDate()
	{
		$trip = Trip::activeTrip()->first();
		$arrivalDate = Carbon::parse($trip->start_date)->format('Y-m-d');
		$weekStartDate = Carbon::parse($trip->start_date)->startOfWeek()->format('Y-m-d');
		return [$arrivalDate, $weekStartDate];
	}

    public function studentCounts()
	{
		list($arrivalDate, $weekStartDate) = $this->tripDate();
		$dates = Helper::getCurentYearDates($arrivalDate);

		$yearStudentCount = Student::whereHas('trip', function($query) use($dates) {
								$query->whereBetween('start_date', [$dates['startDate'], $dates['endDate']]);
							})
							->count();
		$weekStudentCount = Student::whereHas('trip', function($query) {
	                	$query->where('status', Trip::ACTIVE);
	                })->count();
		return [$arrivalDate, $weekStartDate, $weekStudentCount, $yearStudentCount];
	}

	public function getTrip(int $scheduleTripId)
    {
    	$schedule = Schedule::with([
    		'school:id,name',
    		'school.principal:id,first_name,last_name,school_id,email'
    	])->find($scheduleTripId);
    	$schedule->status =  ucfirst(strtolower($schedule->status));
    	return $schedule;
    }

    public function saveTrip(array $requestData)
    {
    	$schedule = Schedule::find($requestData['schedule_id']);
    	$schedule->status = $requestData['status'];
    	$schedule->trip_date = Carbon::create($requestData['trip_date']);
    	$schedule->teacher = $requestData['teacher'];
    	$schedule->students = $requestData['students'];
    	$schedule->save();

    	$schedule->status = ucfirst(strtolower($schedule->status));
    	return $schedule;
    }

    public function confirmTrip(array $requestData)
    {
    	$schedule = $this->getTrip($requestData['schedule_id']);
    	$allClasses = Schedule::where('school_id', $schedule->school_id)
    							->where('trip_number', $schedule->trip_number)
    							->where('type', $schedule->type)
    							->where('trip_date', Carbon::create($schedule->trip_date))
    							->get();

    	$type = $schedule->type === Schedule::DAY ? 'Day' : 'Week';
    	if(isset($requestData['confirmation'])){

            $allTeachers = $allClasses->pluck('teacher','id')->toArray();
            $teacherRoute = $allTeachers !== null ? route('schedule.teacher.registration',[base64_encode(implode('#', array_keys($allTeachers)))]) : null;

            $links = '';
            if($allTeachers !== null){
                foreach($allTeachers as $teacherKey => $teacherValue){
                $links .= '<p>'.$teacherValue.': <a href="'.$teacherRoute.'" target="_blank" class="link-black ">'.$teacherRoute.'</a></p>';
                }
            }

	    	$mappingData = [
	    		'{type}' => $type,
	            '{first_name}' => $schedule->school->principal->first_name,
	            '{last_name}' => $schedule->school->principal->last_name,
	            '{schoolName}' => $schedule->school->name,
	            '{links}' => $links,
	            'toMail' => $schedule->school->principal->email,
	        ];

            if($schedule->type === Schedule::WEEK) {
                request()->session()->put('allClasses', $allTeachers);
            }

	        //Send mail to principal
	        MailTrait::emailTemplateMapping($type.'TripConfirmed', $mappingData);

	        /*if($schedule->type === Schedule::WEEK){
	        	if($allClasses){
	        		foreach ($allClasses as $class) {
	        			MailTrait::emailTemplateMapping('StudentInformation', $mappingData);
		        		MailTrait::emailTemplateMapping('MealInformation', $mappingData);
	        		}
	        	}
		    }*/
		}

    	if(isset($requestData['confirmation'])){
	    	$schedule->confirmation_send = $requestData['confirmation'];
	    	$schedule->confirmation_send_date = Carbon::now();
	    }

    	if($schedule->type === Schedule::WEEK){ //&& isset($requestData['bill'])
            if(isset($requestData['bill'])){
        		$schedule->bill_send = $requestData['bill'];
        		$schedule->bill_send_date = Carbon::now();
        		$schedule->bill_status = Schedule::SENT;
            }

            $billMappingData = [
                '{days}' => $schedule->days,
                '{classes}' => $allClasses->count(),
                '{date}' => $schedule->trip_date,
                '{first_name}' => $schedule->school->principal->first_name,
                '{last_name}' => $schedule->school->principal->last_name,
                '{schoolName}' => $schedule->school->name,
                'toMail' => $schedule->school->principal->email,
            ];
    		$this->generateBillPdf($schedule->id, isset($requestData['bill']) ? true : false, $billMappingData);
    	}

    	$schedule->status = $requestData['status'];
    	$schedule->save();

    	request()->session()->put('principalName', $schedule->school->principal->first_name.' '.$schedule->school->principal->last_name);

    	/*$scheduleData = [
    		'status' => $requestData['status'],
    	];
    	if(isset($requestData['confirmation'])){
    		$scheduleData['confirmation_send'] = $requestData['confirmation'];
    		$scheduleData['confirmation_send_date'] = Carbon::now();
    	}
    	if($schedule->type === Schedule::WEEK && isset($requestData['bill'])){
    		$scheduleData['bill_send'] = $requestData['bill'];
    		$scheduleData['bill_send_date'] = Carbon::now();
    		$scheduleData['bill_status'] = Schedule::SENT;
    	}
    	Schedule::whereIn('id',$allClasses->pluck('id'))->update($scheduleData);*/
    }

    public function billInfo(int $scheduleId)
    {
    	$billLetter = EmailTemplate::name('BillInformation')->first()->toArray();
    	$schedule = Schedule::find($scheduleId);
    	$allClassesCount = Schedule::where('school_id', $schedule->school_id)
    							->where('trip_number', $schedule->trip_number)
    							->where('type', $schedule->type)
    							->where('trip_date', Carbon::create($schedule->trip_date))
    							->count();

        $data = $this->getMealdataFormate($scheduleId);
        $mappingData = [
    		'{days}' => $data['days'],
    		'{classes}' => $allClassesCount,
            '{date}' => $schedule->trip_date,
            '{first_name}' => $data['principal_f_name'],
            '{last_name}' => $data['principal_l_name'],
            '{schoolName}' => $data['schoolName'],
            'toMail' => $data['principal_email'],
        ];

        $data['subject'] = strtr($billLetter['subject'], $mappingData);
        $data['title'] = 'Bill: '.$data['days'].' day trip, '.$allClassesCount.' classes | '.$data['schoolName'];
        $data['sent_on'] = $schedule->bill_send_date;
        $data['status'] = ucfirst(strtolower($schedule->bill_status));
    	return $data;
    }

    public function getMealdataFormate(int $scheduleId)
    {
    	$schedule = Schedule::with([
            'school:id,name,district_id',
            'school.principal:id,first_name,last_name,school_id,email',
            'school.administrator:id,first_name,last_name,school_id,email,address,city_id,state_id,zip',
            'school.district:id,name',
            'school.administrator.city:id,name',
            'school.administrator.state:id,code',
        ])->find($scheduleId);

        $fees = MealFee::where('days', $schedule->days)->pluck('price','type');

        $tripDate = Carbon::create($schedule->trip_date)->format('F d').'-'.Carbon::create($schedule->trip_date)->addDays($schedule->days)->format('d');
        $data = [
            'from' => $schedule->school->administrator->first_name.' '.$schedule->school->administrator->last_name.', Administrator, SCICON',
            're' => 'SCICON Week Trip Billing for 2023/2024',
            'district' => $schedule->school->district->name,
            'address' => $schedule->school->administrator->address,
            'city' => $schedule->school->administrator->city->name.', '.$schedule->school->administrator->state->code,
            'zip' => $schedule->school->administrator->zip,
            'fullAddress' => $schedule->school->district->name.'<br>'.$schedule->school->administrator->address.'<br>'.$schedule->school->administrator->city->name.', '.$schedule->school->administrator->state->code.'<br>'.$schedule->school->administrator->zip,
            'schoolName' => $schedule->school->name,
            'students' => $schedule->students,
            'attendance'=> $schedule->students,
            'teacherCount' => 1,
            'counselorCount' => 4,
            'days' => $schedule->days,
            'fees' => $fees,
            'tripDate' => $tripDate,
            'date' => Carbon::create($schedule->trip_date)->format('m_d_Y'),
            'principal_f_name' => $schedule->school->principal->first_name,
            'principal_l_name' => $schedule->school->principal->last_name,
            'principal_email' => $schedule->school->principal->email,
            'principal_id' => $schedule->school->principal->id,
            'teacher' => $schedule->teacher,
        ];
        return $data;
    }

    public function generateBillPdf(int $scheduleId, bool $isSession = false, array $billMappingData = [])
    {
        $data = $this->getMealdataFormate($scheduleId);
        $fileName = str_replace(' ','_', ($data['schoolName'].'_'.$data['teacher'].'_'.$data['date'].'_MealBill.PDF'));
        $path = Helper::createFolder('mail');
        $filepath = $path .'/'. $fileName;
        $pdf = PDF::loadView('trips.mealBillPdf', compact('data'));
        $pdf->save($filepath);
        $billFileRoute = route('download','public/mail/'.$fileName);
        if($isSession === true){
        	request()->session()->put('billFileRoute', $billFileRoute);
            if($billMappingData !== null){
                $billMappingData['attachFile'] = $fileName;

                //Send mail to principal
                MailTrait::emailTemplateMapping('BillInformation', $billMappingData);
            }
        }
        return $billFileRoute;
    }

    public function sendBill(array $requestData)
    {
    	$schedule = $this->getTrip($requestData['schedule_id']);

    	$mappingData = [
            '{first_name}' => $schedule->school->principal->first_name,
            '{last_name}' => $schedule->school->principal->last_name,
        ];

    	if($requestData['type'] === 'Confirmed') {
    		$data= [
	        	'fromMail' => env('FROM_MAIL'),
		        'toMail' => $schedule->school->principal->email,
		        'subject' => $requestData['subject'],
		        'message' => strtr($requestData['messageBody'],  $mappingData),
	        ];
	       
	        //Send mail to principal
	        MailTrait::customEmailSend($data);

	        $schedule->confirmation_send = Schedule::YES;
	    	$schedule->confirmation_send_date = Carbon::now();
	    }

	    if($requestData['type'] === 'Bill') {

	    	$fileName = str_replace(' ','_', ($schedule->school->name.'_'.Carbon::create($schedule->trip_date)->format('m_d_Y').'_MealBill.PDF'));
        	$filepath = 'app/public/mail/'. $fileName;

        	$mappingData['toMail'] = $schedule->school->principal->email;
	    	$mappingData['attachFile'] = $fileName;

	    	//Send mail to principal
	        MailTrait::emailTemplateMapping('BillInformation', $mappingData, $requestData['subject']);

	        $schedule->bill_send = Schedule::YES;
    		$schedule->bill_send_date = Carbon::now();
    		$schedule->bill_status = Schedule::SENT;
	    }

    	$schedule->save();
    }

    public function updateBillStatus(array $requestData)
    {
    	//$schedule = Schedule::find($requestData['schedule_id']);
    	$schedule = Schedule::with([
			    		'school:id,name',
			    		'school.principal:id,first_name,last_name,school_id,email'
			    	])->find($requestData['schedule_id']);

    	$allClasses = Schedule::where('school_id', $schedule->school_id)
    							->where('trip_number', $schedule->trip_number)
    							->where('type', $schedule->type)
    							->where('trip_date', Carbon::create($schedule->trip_date))
    							->get();

    	$schedule->bill_status = $requestData['bill_status'];
    	$schedule->save();

    	$mappingData = [
            '{name}' => $schedule->school->principal->full_name,
            '{clickHere}' => '<a href="'.route('schedule.teacher.registration',[base64_encode(implode('#',$allClasses->pluck('id')->toArray()))]).'" target="_blank">Click here</a>',
            'toMail' => $schedule->school->principal->email,
        ];

        //send mail to principal
        MailTrait::emailTemplateMapping('StudentInformation', $mappingData);

        //Send mail to teachers
        /*if(count($allClasses) > 0) {
        	foreach($allClasses as $class){
                if($schedule->id === $class->id){
            		$mappingData['{name}'] = $class->teacher;
            		$mappingData['toMail'] = $class->email;
            		MailTrait::emailTemplateMapping('StudentInformation', $mappingData);
                }
        	}
        }*/
    }

    public function storeStudentInfo(array $requestData)
    {
        $scheduleId = $requestData['schedule_id'];
        $key = $requestData['key'];
        $firstnames = $requestData['firstname_'.$key];
        $now = Carbon::now()->toDateTimeString();
        $studentIds = [];
        $schedule = Schedule::find($scheduleId);
        $genders = $firstnames[0] === null ? array_merge(['0' => null], $requestData['gender_'.$key]) : $requestData['gender_'.$key];
        $deleteSchedule = isset($requestData['deleteSchedule']) ? false : true ;

        if(count($firstnames) > 0) {
            foreach($firstnames as $sKey => $firstname) {
                if($firstname !== null && $firstname !== ''){

                    $student = $schedule->studentInfo()->updateOrCreate(
                        ['id' => $requestData['ids_'.$key][$sKey] ?? null ],
                        [
                            'schedule_id' => $scheduleId,
                            'student_name' => ucwords($firstname.' '.$requestData['lastname_'.$key][$sKey]),
                            'first_name' => ucfirst($firstname),
                            'last_name' => ucfirst($requestData['lastname_'.$key][$sKey]),
                            'gender' => $genders[$sKey],
                            'is_disability' => ucfirst($requestData['disability_'.$key][$sKey]),
                            'teacher_cabin_id' => $requestData['cabin_id_'.$key][$sKey],
                            'note' => $requestData['notes_'.$key][$sKey],
                        ]
                    );
                    $studentIds[] = $student->id;
                }
            }
            if($deleteSchedule){
                $schedule->studentInfo()->whereNotIn('id', $studentIds)->delete();
            }
        }

        if(isset($requestData['meal_name']) && isset($requestData['meal_email'])){
            $schedule->send_meal_request = Schedule::YES;
            $schedule->meal_name = $requestData['meal_name'];
            $schedule->meal_email = $requestData['meal_email'];
            $schedule->meal_phone = $requestData['meal_phone'];
            $schedule->teacher = $requestData['teacher'];
            $schedule->save();

            $mappingData = [
                '{name}' => $requestData['meal_name'],
                '{clickHere}' => '<a href="'.route('schedule.meal.registration',[$requestData['all_classes']]).'" target="_blank">Click here</a>',
                'toMail' => $requestData['meal_email'],
            ];

            //send mail to Food Manager
            MailTrait::emailTemplateMapping('MealInformation', $mappingData);
        } else {
            $schedule->status = $requestData['status'];
            $schedule->save();
        }
    }

     public function storeMealInfo(array $requestData)
    {
        $key = $requestData['key'];
        $scheduleId = $requestData['schedule_id_'.$key];
        $students = $requestData['students_'.$key];
        $mealAmount = $requestData['meal_amount_'.$key];
        $mealType = $requestData['meal_type_'.$key];
        $mealName = $requestData['meal_name_'.$key];
        $mealTitle = $requestData['meal_title_'.$key];
        $schedule = Schedule::find($scheduleId);

        if(count($students) > 0) {
            foreach($students as $sKey => $student) {
                if($student !== null && $student !== ''){
                    $student = $schedule->studentInfo()->updateOrCreate(
                        ['id' => $requestData['students_'.$key][$sKey] ?? null ],
                        [
                            'free_meal' => $mealType[$sKey] === 'Free' ? ScheduleStudent::YES : ScheduleStudent::NO,
                            'free_amount' => $mealType[$sKey] === 'Free' ? $mealAmount[$sKey] : 0,
                            'paid_meal' => $mealType[$sKey] === 'Paid' ? ScheduleStudent::YES : ScheduleStudent::NO,
                            'paid_amount' => $mealType[$sKey] === 'Paid' ? $mealAmount[$sKey] : 0,
                            'reduced_meal' => $mealType[$sKey] === 'Reduced' ? ScheduleStudent::YES : ScheduleStudent::NO,
                            'reduced_amount' => $mealType[$sKey] === 'Reduced' ? $mealAmount[$sKey] : 0,
                            'schedule_id' => $scheduleId,  
                        ]
                    );
                }
            }
        }

        if(isset($mealName) ){
            /*if(request()->has('meal_signature')){
                $signature = request()->meal_signature;
                $extension = $signature->getClientOriginalExtension();
                $filename = str_replace(' ', '_', $mealName).'_Signature_'.time().'.'.$extension;
                $file = $signature->storeAs('public/signatures',$filename);
                $schedule->meal_signature = $filename;
            }*/

            if(isset($requestData['signature_'.$key])){
                $image_parts = explode(";base64,", $requestData['signature_'.$key]);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = str_replace(' ', '_', $mealName).'_Signature_'.time().'.'.$image_type;
                $path = Helper::createFolder('signatures');
                $file = $path .'/'. $fileName;
                file_put_contents($file, $image_base64);
                $schedule->meal_signature = $fileName;
            }

            $schedule->free_amount = $requestData['free_amount_'.$key] ?? 0;
            $schedule->paid_amount = $requestData['paid_amount_'.$key] ?? 0;
            $schedule->reduced_amount = $requestData['reduced_amount_'.$key] ?? 0;
            $schedule->meal_name = $mealName;
            $schedule->meal_title = $mealTitle;
            $schedule->save();

            /*$mappingData = [
                '{name}' => $schedule->teacher,
                'toMail' => $schedule->email,
                'fromMail' => $schedule->meal_email,
            ];
            //send mail to Teacher
           MailTrait::emailTemplateMapping('MealInformationSuccess', $mappingData);*/
        }
    }

    public function tripList(string $type = null, string $village = null)
    {
        $village = $village ? base64_decode($village) : 'bear_creek';
        $dates = Helper::getCurentYearDates( Carbon::now()->format('Y-m-d'));

        $schedules = Schedule::with(['school:id,name'])
                    ->when(($type !== null && $type !== 'full'), function($query) use($type){
                        $query->where('type', strtoupper($type));
                    })
                    ->when(($village !== null && $village === 'eagle_point'), function($query) use($type){
                        $query->where('is_eagle_point', Schedule::YES);
                    })
                    ->whereBetween('trip_date', [$dates['startDate'], $dates['endDate']])
                    //->where('type', strtoupper('day'))
                    ->orderBy('type','desc')->get();
        $scheduleArray = [];
        $colors = [
            'PENDING' => 'rgb(184, 156, 58, 0.5)', //'#B89C3A',
            'CONFIRMED' => 'rgb(84, 84, 84, 0.5)', //'#545454',
            'REGISTERED' => 'rgb(39, 107, 100, 0.5)', //'#276B64'
        ];

        $dates = [];
        if($schedules) {
            foreach($schedules as $key => $schedule) {

                $startDate = Carbon::create($schedule->trip_date)->format('Y-m-d');
                $dates[$key] = $startDate;

                $scheduleArray[$key] = [
                    "start" => $startDate,
                    "end" => Carbon::create($schedule->trip_date)->addDays($schedule->days)->format('Y-m-d'),
                ];

                //if($type !== null){
                /*if($type === 'day'){
                    $scheduleArray[$key]["type"] = $type;
                    //$scheduleArray[$key]["display"] = 'background';
                    $scheduleArray[$key]["backgroundColor"] = $colors[$schedule->status];
                    $scheduleArray[$key]["textColor"] = '#000';
                    $scheduleArray[$key]["title"] = $schedule->school->name.': '.$schedule->students.' '.ucfirst(strtolower($schedule->status));
                    $count = $schedules->where('trip_date', $schedule->trip_date)->count();
                    $scheduleArray[$key]["width"] = number_format((100/$count), 2)."%";

                    if(in_array($startDate, $dates)){
                        $arrayCount = array_count_values($dates);
                        $scheduleArray[$key]["left"] = $arrayCount[$startDate] === 1 ? '0%' : (number_format((100/$count),2) * ((int) $arrayCount[$startDate] - 1)).'%';
                        //$scheduleArray[$key]["borderRadius"] = $count === 1 ? '0.5rem' : ($arrayCount[$startDate] === 1 ? '0.5rem 0rem 0rem 0.5rem' : ($count == $arrayCount[$startDate] ? '0rem 0.5rem 0.5rem 0rem' : '0rem'));
                    }
                } else {*/
                    $scheduleArray[$key]["type"] = $type !== 'full' ? strtolower($schedule->type) : '';
                    $scheduleArray[$key]["title"] = $schedule->students.': '.$schedule->school->name;//.'('.$schedule->days.')';
                    $scheduleArray[$key]["backgroundColor"] = $colors[$schedule->status];
                    $scheduleArray[$key]["textColor"] = '#000';
                //}
            }
        }
        return $scheduleArray;
    }

    public function tripDateList(string $date)
    {
        $schedules = Schedule::where('trip_date', Carbon::create(base64_decode($date)))
                    ->with([
                        'studentInfo:id,schedule_id,student_name',
                        'school:id,name'
                    ])
                    ->get();

        return [
            'list' => $schedules,
            'total' => $schedules->count(),
            'students' => $schedules->sum('students'),
        ];
    }

    public function studentDelete(array $requestData)
    {
        ScheduleStudent::whereIn('id', $requestData['ids'])->delete();
    }
}