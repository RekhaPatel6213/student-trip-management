<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Cabin;
use Illuminate\Http\Request;
use App\Services\ScheduleService;
use App\Traits\BreadCrumbTrait;

class ScheduleController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new ScheduleService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //list($arrivalDate, $weekStartDate) = $this->service->tripDate();
            list($arrivalDate, $weekStartDate, $weekStudentCount, $yearStudentCount) = $this->service->studentCounts();

            $breadCrumb = BreadCrumbTrait::breadCrumb('Scheduling', 'schedule.index', null);
            return view('schedule.index',compact('breadCrumb', 'arrivalDate', 'weekStartDate', 'weekStudentCount', 'yearStudentCount'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, $this->service->getTrip($schedule->id)->toArray());
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function update(Request $request)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, __('actions.saveSuccess', ['page' => __('message.trip')]), $this->service->saveTrip($request->all())->toArray());
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function statusUpdate(Request $request)
    {
        if(request()->ajax()) {
            try {
                $schedule = Schedule::find($request->schedule_id);
                $schedule->status = $request->status;
                $schedule->save();
                return $this->returnJsonResponse(true, __('actions.saveSuccess', ['page' => __('message.trip')]), null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function destroy(Schedule $schedule, Request $request)
    {
        if($request->ajax()) {
            try {
                $schedule->delete();
                return response()->json([
                    'result' => true,
                    'message' => __('actions.deletedSuccess',['page' => __('message.trip')]),
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'result' => false,
                    'message' =>$e->getMessage(),
                ]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function confirm(Request $request)
    {
        if(request()->ajax()) {
            try {
                $this->service->confirmTrip($request->all());
                return $this->returnJsonResponse(true, __('actions.confirmSuccess', ['page' => __('message.trip')]), null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function confirmSuccess(Request $request)
    {
        try {
            return view('trips.confirmSuccess');
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function billInfo(int $scheduleId)
    {
        if(request()->ajax()) {
            try {
                $data = $this->service->billInfo($scheduleId);
                $returnHTML = view('trips.mealBill')->with('data', $data)->render(); 
                return response()->json(array('status' => true, 'message' => null, 'data' => $returnHTML));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function billPDF(int $scheduleId)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, ['filePath' => $this->service->generateBillPdf($scheduleId)]);

            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function sendMail(Request $request)
    {
        if(request()->ajax()) {
            try {
                $this->service->sendBill($request->all());
                return $this->returnJsonResponse(true, '', null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function updateBillStatus(Request $request)
    {
        if(request()->ajax()) {
            try {

                return $this->returnJsonResponse(true, __('actions.billStatusUpdate'), $this->service->updateBillStatus($request->all()));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function teacherRegistration(string $scheduleId)
    {
        try {
            $scheduleId = base64_decode($scheduleId);
            $scheduleIds = explode('#', $scheduleId);
            $schedules = Schedule::with(['studentInfo'])->whereIn('id', $scheduleIds)->get();
            $schedule = $schedules->where('id', $scheduleIds[0]);
            $teacherCabins = config('constants.teacherCabins');
            return view('trips.teacherRegistration', compact('scheduleId', 'schedule', 'schedules', 'teacherCabins'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function storeStudentInfo(Request $request){
        if(request()->ajax()) {
            try {
                $this->service->storeStudentInfo($request->all());
                return $this->returnJsonResponse(true, '', null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function teacherRegistrationSuccess()
    {
        try {
            return view('trips.teacherRegistrationSuccess');
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function mealRegistration(string $scheduleId)
    {
        try {
            $scheduleId = base64_decode($scheduleId);
            $scheduleIds = explode('#', $scheduleId);
            $schedules = Schedule::with(['studentInfo'])->whereIn('id', $scheduleIds)->get();
            return view('trips.mealRegistration', compact('scheduleId', 'schedules'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function storeMealInfo(Request $request){
        if(request()->ajax()) {
            try {
                $this->service->storeMealInfo($request->all());
                return $this->returnJsonResponse(true, '', null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function mealRegistrationSuccess()
    {
        try {
            return view('trips.mealRegistrationSuccess');
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function calendarView()
    {
        try {
            return view('schedule.calendarView');
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function tripList(string $type = null, string $village = null)
    {
        try {
            return response()->json($this->service->tripList($type, $village));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function tripDateList(string $date)
    {
        try {
            $schedules = $this->service->tripDateList($date);
            return view('trips.dateList',compact('schedules', 'date'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function tripClassInfo(string $scheduleId)
    {
        try {
            $scheduleId = base64_decode($scheduleId);
            $schedule = Schedule::with(['school:id,name','studentInfo.cabin'])->find($scheduleId);
            $cabins = Cabin::select('name','id','gender','block_week')->get();
            return view('trips.classInfo', compact('scheduleId', 'schedule', 'cabins'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function studentDelete(Request $request)
    {
        if($request->ajax()) {
            try {
                $this->service->studentDelete($request->all());
                return response()->json([
                    'result' => true,
                    'message' => __('actions.deletedSuccess',['page' => __('message.student')]),
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'result' => false,
                    'message' =>$e->getMessage(),
                ]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

}
