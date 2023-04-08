<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\School;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use App\Services\TripService;
use App\Traits\BreadCrumbTrait;

class TripController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new TripService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dayTripList()
    {
        try {
            $type = Trip::DAY;
            $trips = $this->service->list($type);
            $breadCrumb = BreadCrumbTrait::breadCrumb('Day Trip Management', 'trips.day', null);
            return view('trips.list',compact('trips', 'breadCrumb', 'type'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $type = null, string $village = null)
    {
        try {
            $type = $type ?? 'day';
            if(!in_array($type, ['day', 'week'])){
                return view('errors.404');
            }

            $village = $village ? base64_decode($village) : 'bear_creek';
            if(!in_array($village, ['bear_creek', 'eagle_point'])){
                return view('errors.404');
            }

            $schools = School::select('id','name','district_id')->with(['district:id,name'])->orderBy('name','asc')->get();
            $schedules = $this->service->scheduleTrips($type, $village);
            $tripInvites = $this->service->getTripInvites($village);
            return view('trips.trip_calander',compact('schedules', 'type', 'village', 'schools', 'tripInvites'));
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
            $breadCrumb = BreadCrumbTrait::breadCrumb('Trip Management', 'trips.index', 'Create');
            return view('trips.create',compact('breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TripRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TripRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect($request->type === Trip::WEEK ? "trips" : "trips/day")->withSuccess(ucfirst(strtolower($request->type)). ' Trip details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    /*public function show(Trip $trip)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Trip Management', 'trips.index', 'Show')
            return view('trips.show',compact('breadCrumb', 'trip'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function edit(Trip $trip)
    {
        try {
            $type = ucfirst(strtolower($trip->type));
            $breadCrumb = BreadCrumbTrait::breadCrumb($type.' Trip Management', 'trips.index', $trip->start_date);
            return view('trips.create',compact('trip', 'breadCrumb','type'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TripRequest  $request
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function update(TripRequest $request, Trip $trip)
    {
        try {
            $this->service->update($request->all(), $trip);
            return redirect($trip->type === Trip::WEEK ? "trips" : "trips/day")->withSuccess(ucfirst(strtolower($trip->type)). ' Trip details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trip  $trip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        try {
            $trip->delete();
            return redirect()
                    ->route($trip->type === Trip::WEEK ? "trips.index" : "trips.list.day")
                    ->with('success', ucfirst(strtolower($trip->type)). ' Trip deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.trips')]),
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
