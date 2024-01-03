<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function verify()
    {
        return view('pages.user.verify');
    }

    public function resend(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('home')->with('successMessage', 'Your email is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('successMessage', 'Verification link has been sent to your email!');
    }
}
