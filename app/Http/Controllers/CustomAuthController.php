<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        if(Auth::check()){
            return redirect('dashboard');
        }
        return view('auth.login');
    }  
    
    /**
     * Write code on Method
     *
     * @return response()
     */  
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect()->route("login")->withSuccess('Login details are not valid!');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }    

    /**
     * Write code on Method
     *
     * @return response()
     */ 
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect()->route("login");
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route('login');
    }
}