<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\District;
use App\Models\School;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\AdministratorRequest;
use App\Services\AdministratorService;
use App\Traits\BreadCrumbTrait;
use DB;

class AdministratorController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new AdministratorService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $schoolId = $request->schoolId??null;
            $administrators = $this->service->list($schoolId);
            $breadCrumb = BreadCrumbTrait::breadCrumb('Administrator Management', 'administrators.index', null);
            return view('administrators.list',compact('administrators', 'breadCrumb', 'schoolId'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $districts = District::orderby('name','asc')->pluck('name', 'id');
            $schools = School::select('name', 'id','district_id')->get();
            $states = State::pluck('code', 'id');
            $cities = City::pluck('name', 'id');
            $schoolId = $request->schoolId??null;
            $districtId = $schoolId !== null ? $schools->where('id', $schoolId)->first()->district_id : null;
            $schools = $schools->toArray();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Administrator Management', 'administrators.index', 'Create');
            return view('administrators.create',compact('breadCrumb', 'districts', 'schools', 'states', 'cities', 'schoolId', 'districtId'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdministratorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect()->route('administrators.index',['schoolId'=>$request->schoolId])->withSuccess('Administrator details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, $this->service->withFind($administrator->id)->toArray());
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $administrator, Request $request)
    {
        try {
            $districts = District::orderby('name','asc')->pluck('name', 'id');
            $schools = School::select('name', 'id','district_id')->get()->toArray();
            $states = State::pluck('code', 'id');
            $cities = City::pluck('name', 'id');
            $schoolId = $request->schoolId??null;
            $districtId = null;

            $breadCrumb = BreadCrumbTrait::breadCrumb('Administrator Management', 'administrators.index', $administrator->full_name);
            return view('administrators.create',compact('administrator', 'breadCrumb', 'districts', 'schools', 'states', 'cities','schoolId','districtId'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdministratorRequest  $request
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request, Administrator $administrator)
    {
        try {
            $this->service->update($request->all(), $administrator);
            return redirect()->route('administrators.index',['schoolId'=>$request->schoolId])->withSuccess('Administrator details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator, Request $request)
    {
        try {
            $administrator->delete();
            return redirect()->route('administrators.index',['schoolId'=>$request->schoolId??null])
                        ->with('success','Administrator deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.administrators')]),
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
