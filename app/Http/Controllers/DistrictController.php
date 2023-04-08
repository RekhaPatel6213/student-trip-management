<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Requests\DistrictRequest;
use App\Services\DistrictService;
use App\Traits\BreadCrumbTrait;

class DistrictController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new DistrictService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $districts = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('District Management', 'districts.index', null);
            return view('districts.list',compact('districts', 'breadCrumb'));

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
            $breadCrumb = BreadCrumbTrait::breadCrumb('District Management', 'districts.index', 'Create');
            return view('districts.create',compact('breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DistrictRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect("districts")->withSuccess('District details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    /*public function show(District $district)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('District Management', 'districts.index', 'Show');
            return view('districts.show',compact('breadCrumb', 'district'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('District Management', 'districts.index', $district->name);
            return view('districts.create',compact('district', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DistrictRequest  $request
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, District $district)
    {
        try {
            $this->service->update($request->all(), $district);
            return redirect("districts")->withSuccess('District details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        try {
            $district->delete();
            return redirect()->route('districts.index')
                        ->with('success','District deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.districts')]),
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
