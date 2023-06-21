<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registerForm(){
        return view('ownerRegistration');
      }
      public function saveOwnerRegistration(Request $request){
        $regField = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8',
        ]);

        $regField['password'] = bcrypt($regField['password']);
        $regField['user_type'] = 'owner';

        //dd($regField);
        $user = User::create($regField);
        auth()->login($user);

        //return redirect('/')->with('message', 'User created and logged in successfully!');
        return redirect('/employee-list')->with('message', 'Owner created and logged in successfully!');

    }
    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message','you have been logged out');
    }
    public function showLoginPage(){
        return view('loginPage');
    }
    public function userLogin(Request $request)
    {
        $loginField = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (auth()->attempt($loginField)) {
            $request->session()->regenerate();

            $user = auth()->user();

            if ($user->user_type === 'owner') {
                return redirect('/employee-list')->with('message', 'You are logged in');
            } elseif ($user->user_type === 'employee') {
                return redirect('/check-in-out-page')->with('message', 'You are logged in');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function employeeList()
    {
        // Get the currently logged-in owner
        $owner = auth()->user();

        // Get the employees associated with the owner
        $employees = User::where('user_type', 'employee')
            ->where('owner_id', $owner->id)
            ->get();

        return view('employeeList', ['employees' => $employees]);
    }

    public function addEmployeeForm(){
        return view('addEmployeeForm');
    }


    public function saveEmployeeRegistration(Request $request)
    {
        $regField = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:8',
        ]);

        $regField['password'] = bcrypt($regField['password']);
        $regField['user_type'] = 'employee';
        $regField['owner_id'] = auth()->id();

        $employee = User::create($regField);
        //dd($employee);

        // Redirect to the employee list page with a success message
        return redirect('/employee-list')->with('message', 'Employee added successfully!');
    }




}
