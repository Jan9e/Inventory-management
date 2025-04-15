<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //This method will show login page for customer
    public function index(){
        return view('login');
    }

    //This function will authenticate the users
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }
        else{
            if(Auth:: attempt(['email'=> $request->email, 'password'=>$request->password])){
                return redirect()->route('account.dashboard');
            }
            else{
                return redirect()->route('account.login')->with('error','Either email or password is incorrect');
            }
        }
    }

    //This function will register the users
    public function register(){
        return view('register');
    }

    public function registerProcess(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6'
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name= $request->name;
            $user->email= $request->email;
            $user->password= Hash::make($request->password);
            $user->role='customer';
            $user->save();

            return redirect()->route('account.login')->with('success', 'You have registered successfully.');
        }else{
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You have successfully logged out');
    }
}
