<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const EMPLOYER = 'employer';

    // Seeker
    public function createSeeker()
    {
        return view('pages.user.seeker-register');
    }

    public function storeSeeker(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => self::JOB_SEEKER,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return back()->with('successMessage', 'Plase verify your email sent to your inbox.');
    }

    // Employer
    public function createEmployer()
    {
        return view('pages.user.employer-register');
    }

    public function storeEmployer(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => self::EMPLOYER,
            'password' => Hash::make($request->password),
            'user_trial' => now()->addWeek(),
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        return back()->with('successMessage', 'Plase verify your email sent to your inbox.');
    }

    // Login
    public function login()
    {
        return view('pages.user.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->user_type == self::EMPLOYER) {
                return redirect()->intended('dashboard');
            }
            return redirect()->intended('/');
        }
        return back()->with('message', 'Whoops! Invalid email or password.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Profile
    public function profile()
    {
        $user = Auth::user();
        return view('pages.user.profile',  compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();
        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('images/profile', 'public');
            User::find(auth()->user()->id)->update([
                'profile_pic' => $imagePath,
            ]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));

        return back()->with('success', 'Your profile was updated successfully.');
    }

    public function updateSeekerProfile(Request $request)
    {
        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('images/profile', 'public');
            User::find(auth()->user()->id)->update([
                'profile_pic' => $imagePath,
            ]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));

        return back()->with('success', 'Your profile was updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Whoops! Invalid current password.');
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Your password was updated successfully.');
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');
        User::find(auth()->user()->id)->update([
            'resume' => $resumePath,
        ]);

        return back()->with('success', 'Your resume was uploaded successfully.');
    }

    public function seekerProfile()
    {
        $user = Auth::user();
        return view('pages.user.seeker-profile',  compact('user'));
    }
}
