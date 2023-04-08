<?php

namespace App\Http\Controllers;

use App\Models\StaffAssignment;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use App\Services\StaffAssignmentService;
use App\Traits\BreadCrumbTrait;

class StaffAssignmentController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new StaffAssignmentService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $staffAssignments = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Staff Assignment', 'staffAssignments.index', null);
            return view('staffAssignments.list',compact('staffAssignments', 'breadCrumb'));

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
            $users = User::whereHas('role', function($query){ $query->where('name', 'Staff'); })->pluck('name','id');

            $works = Work::select('id','name','is_eagle_point')->staff()->get();
            $breadCrumb = $breadCrumb = BreadCrumbTrait::breadCrumb('Staff Assignment', 'staffAssignments.index', 'New Assignments');
            return view('staffAssignments.create',compact('breadCrumb', 'users', 'works'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function checkSchedule(Request $request)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, $this->service->checkSchedule($request->all()));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->service->store($request->all());
            return redirect()->route('staffAssignments.index')->withSuccess('Staff Assignment details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $date
     * @return \Illuminate\Http\Response
     */
    public function edit(string $date)
    {
        try {
            $date =  base64_decode($date);
            $staffAssignment = $this->service->getAssignments($date);
            $users = User::whereHas('role', function($query){ $query->where('name', 'Staff'); })->pluck('name','id');
            $works = Work::select('id','name','is_eagle_point')->staff()->get();
            $breadCrumb = $breadCrumb = BreadCrumbTrait::breadCrumb('Staff Assignment', 'staffAssignments.index', 'New Assignments');
            return view('staffAssignments.create',compact('breadCrumb', 'users', 'works', 'date', 'staffAssignment'));
        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function downloadStaffAssignmentPDF(string $type, string $date)
    {
        try {
            return $this->service->generateStaffAssignmentPDF($type, $date);
        } catch (Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    public function downloadBulletinPDF(string $date)
    {
        if(request()->ajax()) {
            try {
                return $this->returnJsonResponse(true, null, $this->service->downloadBulletinPDF($date));
            } catch (Exception $exception) {
                return $this->returnJsonResponse(false, $exception->getMessage(), ['error' => $exception->getTrace()]);
            }
        } else {
            return back()->with('error', __('message.somethingWrongTryAgain'));
        }  
    }
}
