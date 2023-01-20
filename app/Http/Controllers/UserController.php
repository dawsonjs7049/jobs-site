<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // show register/create form
    public function create()
    {
        return view('users.register');
    }

    // create new user in db
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'], // at least 3 character
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'] // will check for a password and make sure it matches another input called "password_confirmation"
        ]);

        // hasht he password
        $formFields['password'] = bcrypt($formFields['password']);

        // creates the user
        $user = User::create($formFields);
        
        // login 
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and Logged In');
    }

    // logout user
    public function logout(Request $request)
    {
        // remove user authentication information from user session
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logged Out');
    }

    // show login form
    public function login()
    {
        return view('users.login');
    }

    // log the user in
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'] // will check for a password and make sure it matches another input called "password_confirmation"
        ]);

        if(auth()->attempt($formFields))
        {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Successfully Logged In');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
