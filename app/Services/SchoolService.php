<?php

namespace App\Services;

use App\Repositories\SchoolRepository;
use App\Models\School;
use App\Models\Schedule;
use App\Models\TripInvite;
use App\Traits\MailTrait;
use Carbon\Carbon;

class SchoolService
{
    use MailTrait;

	protected $repository;

    public function __construct()
    {
        $this->repository = new SchoolRepository();
    }

    public function list()
    {
        return $this->repository->getQueryBuilder(null, 'name', 'asc')
                ->with(['district:id,name', 'preScheduleRequest:id,school_id,status','schoolAdministrator:id,school_id,first_name,last_name'])
                ->get();
    }

	public function create(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    public function update(array $requestData, School $school)
    {
        return $this->repository->store($requestData, $school);
    }

    public function bulkDelete(array $requestData)
    {
        return $this->repository->bulkDelete($requestData);
    }

    public function sendScheduleInvite(array $requestData, bool $remind)
    {
        $villageType = $requestData['villageType'] ?? 'bear_creek';
        if(isset($requestData['schoolId'])){
            $school = $this->repository->withFind(['administrator:id,first_name,last_name,school_id,email'], $requestData['schoolId']);
            $this->sendScheduleMail($school, $villageType, $remind, $requestData['type'] ?? null);
        }

        if(isset($requestData['schoolIds'])){
            $schools = School::with(['administrator:id,first_name,last_name,school_id,email'])
                            ->whereIn('id', $requestData['schoolIds'])
                            ->get();

            if(count($schools) > 0){
                foreach($schools as $school){
                    $this->sendScheduleMail($school, $villageType, $remind, $requestData['type'] ?? null);  
                }
            }
        }
    }


    public function sendScheduleMail(School $school, string $villageType, bool $remind, string $type = null)
    {
        if($school->administrator){
            $dayUrl = $weekUrl = '';

            if($remind === false){
                if($type !== 'week'){
                    $dayTripInvite = new TripInvite();
                    $dayTripInvite->school_id = $school->id;
                    $dayTripInvite->invite_url = base64_encode($school->id).'/'.base64_encode('dayTrip').'/'.base64_encode($villageType);
                    $dayTripInvite->type = TripInvite::DAY;
                    $dayTripInvite->village_type = $villageType;
                    $dayTripInvite->remind = TripInvite::NO;
                    $dayTripInvite->status = TripInvite::SEND;
                    $dayTripInvite->save();

                    $dayLink = $type !== 'week' ? route('schools.form.preSchedule',[base64_encode($dayTripInvite->id)]) : '';
                    $dayUrl = '<a href="'.$dayLink.'" style="background-color: #B89C3A; color: #FFF; text-decoration: none; font-size: 12px; padding: 5px 10px; border-radius: 4px;">Pre-Schedule day trip/s</a>';
                }

                if($type !== 'day'){
                    $weekTripInvite = new TripInvite();
                    $weekTripInvite->school_id = $school->id;
                    $weekTripInvite->invite_url = base64_encode($school->id).'/'.base64_encode('weekTrip').'/'.base64_encode($villageType);;
                    $weekTripInvite->type = TripInvite::WEEK;
                    $weekTripInvite->village_type = $villageType;
                    $weekTripInvite->remind = TripInvite::NO;
                    $weekTripInvite->status = TripInvite::SEND;
                    $weekTripInvite->save();

                    $weekLink = $type !== 'day' ? route('schools.form.preSchedule', base64_encode($weekTripInvite->id)) : '';

                    $weekUrl = '<a href="'.$weekLink.'" style="background-color: #276B64; color: #FFF; text-decoration: none; font-size: 12px; padding: 5px 10px; border-radius: 4px; margin-left: 10px;">Pre-schedule week trip/s</a>';
                }
            }

            $mappingData = [
                '{first_name}' => $school->administrator->first_name,
                '{last_name}' => $school->administrator->last_name,
                '{schoolName}' => $school->name,
                '{dayLink}' => $dayUrl,
                '{weekLink}' => $weekUrl,
                'toMail' => $school->administrator->email,
            ];

            //Day-Week Trip
            MailTrait::emailTemplateMapping('PreScheduleTripRequest', $mappingData);

            $school->is_eagle_point = $villageType === 'eagle_point' ? School::YES : School::NO;
            $school->save();
        }
    }

    public function storePreSchedule(array $requestData)
    {
        $type = $requestData['type'];
        $now = Carbon::now()->toDateTimeString();
        $preferredDates = array_filter($requestData['preferred_date']);
        $teachers = $requestData['teacher'];
        $students = $requestData['students'];
        $isEaglePoint = $requestData['is_eagle_point'];

        if(count($preferredDates) > 0) {

            TripInvite::where('id', $requestData['invite_id'])->update(['status' => TripInvite::COMPLETED]);

            foreach($preferredDates as $pKey => $date)
            {
                $tripNumber = $pKey;

                foreach(array_filter($teachers[$tripNumber]) as $tKey => $teacher) {

                    $date = Carbon::create($date);
                    $scheduleArray[] = [
                        'id' => null,
                        'school_id' => $requestData['school_id'],
                        'invite_id' => $requestData['invite_id'],
                        'type' => $type,
                        'days' => $type === Schedule::DAY ? 1 : ($date->format('l') === 'Tuesday' ? 4 : 5) ,
                        'trip_number' => $tripNumber + 1,
                        'trip_date' => $date,
                        'teacher' => $teacher,
                        'students' => $students[$tripNumber][$tKey] ?? null,
                        'status' => Schedule::PENDING,
                        'is_eagle_point' => $isEaglePoint,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            Schedule::upsert($scheduleArray, ['school_id','invite_id','type','days','trip_date','teacher','students','status'], ['id']);
        }
    }
}