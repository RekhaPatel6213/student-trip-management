<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\School;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherRequest;
use App\Services\TeacherService;
use App\Traits\BreadCrumbTrait;

class TeacherController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new TeacherService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $teachers = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Teacher Management', 'teachers.index', null);
            return view('teachers.list',compact('teachers', 'breadCrumb'));

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
            $schools = School::pluck('name', 'id');
            $tripDates = Trip::week()->pluck('start_date', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('Teacher Management', 'teachers.index', 'Create');
            return view('teachers.create',compact('breadCrumb', 'schools', 'tripDates'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect("teachers")->withSuccess('Teacher details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    /*public function show(Teacher $teacher)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Teacher Management','teachers.index', 'Show');
            return view('teachers.show',compact('breadCrumb', 'teacher'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        try {
            $schools = School::pluck('name', 'id');
            $tripDates = Trip::week()->pluck('start_date', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('Teacher Management', 'teachers.index', $teacher->name);
            return view('teachers.create',compact('teacher', 'breadCrumb', 'schools', 'tripDates'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeacherRequest  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        try {
            $this->service->update($request->all(), $teacher);
            return redirect("teachers")->withSuccess('Teacher details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        try {
            $teacher->delete();
            return redirect()->route('teachers.index')
                        ->with('success','Teacher deleted successfully');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }
}
