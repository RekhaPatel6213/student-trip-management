<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CabinService;
use App\Models\ScheduleStudent;
use App\Helpers\Helper;
use Carbon\Carbon;

class CabinAssignmentController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CabinService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $week = null)
    {
        try {
            $cutrrentWeek = $week === null ? Carbon::now()->format('W#Y') : base64_decode($week);
            $weeks = Helper::getCurentYearWeeks();
            $weekDates = $weeks[$cutrrentWeek];
            $assignmentInfo = $this->service->getCabinAssignmentInfo($weekDates['start'], $weekDates['end']);

            //dd($assignmentInfo);
            return view('cabins.assignment',compact('weeks', 'cutrrentWeek', 'assignmentInfo'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function blockCabin(Request $request)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, __('actions.blockedSuccess', ['page' => __('message.cabin')]), $this->service->blockCabin($request->all()));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function autoSortCabin(Request $request)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, '', $this->service->autoSortCabin($request->all()));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $studentId
     * @return \Illuminate\Http\Response
     */
    public function studentDetail(int $studentId)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, $this->service->studentDetail($studentId)->toArray());
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function studentUpdate(int $studentId, Request $request){
        if(request()->ajax()) {
            try {
                $this->service->studentUpdate($studentId, $request->all());
                return $this->returnJsonResponse(true, '', null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    public function updateCabin(Request $request){
        if(request()->ajax()) {
            try {
                $this->service->updateCabin($request->all());
                return $this->returnJsonResponse(true, '', null);
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }
}
