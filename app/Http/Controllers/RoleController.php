<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Traits\BreadCrumbTrait;

class RoleController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new RoleService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('Role Management', 'roles.index', null);
            return view('roles.list',compact('roles', 'breadCrumb'));

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
            $breadCrumb = BreadCrumbTrait::breadCrumb('Role Management', 'roles.index', 'Create');
            return view('roles.create',compact('breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
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
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
            ]);

            $this->service->create($request->only('name'));
            return redirect("roles")->withSuccess('Role details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    /*public function show(Role $role)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Role Management', 'roles.index', 'Show');
            return view('roles.show',compact('breadCrumb', 'role'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('Role Management', 'roles.index', $role->name);
            return view('roles.create',compact('role', 'breadCrumb'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name,'.$role->id.',id',
            ]);
            $this->service->update($request->only('name'), $role);
            return redirect("roles")->withSuccess('Role details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.roles')]),
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
