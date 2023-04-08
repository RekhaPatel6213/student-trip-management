<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\District;
use App\Models\Schedule;
use App\Models\TripInvite;
use Illuminate\Http\Request;
use App\Http\Requests\SchoolRequest;
use App\Services\SchoolService;
use App\Traits\BreadCrumbTrait;

class SchoolController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new SchoolService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $schools = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('School Management', 'schools.index', null);
            return view('schools.list',compact('schools', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $districts = District::orderby('name','asc')->pluck('name', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('School Management', 'schools.index', 'Create');
            return view('schools.create',compact('breadCrumb', 'districts'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SchoolRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect("schools")->withSuccess('School details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    /*public function show(School $school)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('School Management', 'schools.index', 'Show');
            return view('schools.show',compact('breadCrumb', 'school'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function edit(School $school)
    {
        try {
            $districts = District::orderby('name','asc')->pluck('name', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('School Management', 'schools.index', $school->code.' ('.$school->name.')');
            return view('schools.create',compact('school', 'breadCrumb', 'districts'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SchoolRequest  $request
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolRequest $request, School $school)
    {
        try {
            $this->service->update($request->all(), $school);
            return redirect("schools")->withSuccess('School details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        try {
            $school->delete();
            return redirect()->route('schools.index')
                        ->with('success','School deleted successfully');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        if($request->ajax()) {
            try {
                $this->service->bulkDelete($request->all());
                return response()->json([
                    'result' => true,
                    'message' => __('actions.deletedSuccess',['page' => __('message.schools')]),
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

    public function sendScheduleInvite(Request $request)
    {
        if($request->ajax()) {
            try {
                $this->service->sendScheduleInvite($request->all(), false);
                return response()->json([
                    'result' => true,
                    'message' => __('actions.PreScheduleTripRequest'),
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

    public function resendScheduleInvite(Request $request)
    {
        if($request->ajax()) {
            try {
                $this->service->sendScheduleInvite($request->all(), true);
                return response()->json([
                    'result' => true,
                    'message' => __('actions.PreScheduleTripRequest'),
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

    public function preSchedule(string $inviteId)
    {
        try {
            $inviteId = base64_decode($inviteId);
            $invite = TripInvite::with([
                'school' => function($query) {
                    $query->with([
                            'district:id,name',
                            'administrator:id,first_name,last_name,school_id'
                        ]);
                    }
                ])->find($inviteId);

            if($invite->status !== TripInvite::COMPLETED){
                $school = $invite->school;
                $invite->update(['status' => TripInvite::SEEN]);
                $type = $invite->type;
                $isEaglePoint = $invite->village_type === 'eagle_point' ? School::YES : School::NO;
                return view('schools.preSchedule', compact('invite', 'school', 'type', 'isEaglePoint'));
            } else   {
                return redirect("preSchedule/invite/success")->withError('Pre-Schedule Trip has been submitted.');
            } 
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function storePreSchedule(Request $request)
    {
        try {
            $scheduleArray = $this->service->storePreSchedule($request->all());
            return redirect("preSchedule/invite/success");
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function successPreSchedule()
    {
        try {
            return view('schools.preScheduleSuccess');
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }
}
