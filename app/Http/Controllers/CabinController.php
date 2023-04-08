<?php

namespace App\Http\Controllers;

use App\Models\Cabin;
use Illuminate\Http\Request;
use App\Http\Requests\CabinRequest;
use App\Services\CabinService;
use App\Traits\BreadCrumbTrait;

class CabinController extends Controller
{
    use BreadCrumbTrait;

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
    public function index()
    {
        try {
            $cabins = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Cabin Management', 'cabins.index', null);
            return view('cabins.list',compact('cabins', 'breadCrumb'));

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
            $breadCrumb = BreadCrumbTrait::breadCrumb('Cabin Management', 'cabins.index', 'Create');
            return view('cabins.create',compact('breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CabinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CabinRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect("cabins")->withSuccess('Cabin details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    /*public function show(Cabin $cabin)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Cabin Management', 'cabins.index', 'Show');
            return view('cabins.show',compact('breadCrumb', 'cabin'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function edit(Cabin $cabin)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Cabin Management', 'cabins.index', $cabin->name.' ('.$cabin->code.')');
            return view('cabins.create',compact('cabin', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CabinRequest  $request
     * @param  \App\Models\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function update(CabinRequest $request, Cabin $cabin)
    {
        try {
            $this->service->update($request->all(), $cabin);
            return redirect("cabins")->withSuccess('Cabin details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cabin  $cabin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cabin $cabin)
    {
        try {
            $cabin->delete();
            return redirect()->route('cabins.index')
                        ->with('success','Cabin deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.cabins')]),
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
