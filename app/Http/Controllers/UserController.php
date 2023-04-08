<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\BreadCrumbTrait;

class UserController extends Controller
{
    use BreadCrumbTrait;

    protected $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = $this->service->list();
            $breadCrumb = BreadCrumbTrait::breadCrumb('User Management', 'users.index', null);
            return view('users.list',compact('users', 'breadCrumb'));

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
            $roles = Role::role()->pluck('name', 'id');
            $states = State::pluck('code', 'id');
            $cities = City::pluck('name', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('User Management', 'users.index', 'Create');
            return view('users.create',compact('breadCrumb','roles','states', 'cities'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $this->service->create($request->all());
            return redirect("users")->withSuccess('User details are saved!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    /*public function show(User $user)
    {
        try {
            $breadCrumb = BreadCrumbTrait::breadCrumb('User Management', 'users.index', 'Show');
            return view('users.show',compact('breadCrumb', 'user'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        try {
            $roles = Role::role()->pluck('name', 'id');
            $states = State::pluck('code', 'id');
            $cities = City::pluck('name', 'id');
            $breadCrumb = BreadCrumbTrait::breadCrumb('User Management', 'users.index', $user->name);
            return view('users.create',compact('user', 'breadCrumb','roles','states', 'cities'));

        } catch (\Exception $exception) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $this->service->update($request->all(), $user);
            return redirect("users")->withSuccess('User details are updated!');
        } catch (Exception $e) {
            return back()->with('error',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            if(config('constants.USER_ROLE_ID') !== $user->role_id){
                $user->delete();
            }
            return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
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
                    'message' => __('actions.deletedSuccess',['page' => __('message.users')]),
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
