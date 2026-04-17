<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationRequest;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $role = $request->input('role');

        if ($role === 'admin') {
            $password = $request->input('password', '');
            if ($password === env('ADMIN_PASSWORD', 'hospital123')) {
                session(['role' => 'admin']);
                return redirect()->route('track');
            }
            return back()->with('error', 'Incorrect admin password.');
        }

        if ($role === 'donor') {
            $token = trim($request->input('token', ''));
            $req   = DonationRequest::where('donor_token', $token)->first();
            if ($req) {
                return redirect()->route('track.donor', ['token' => $token]);
            }
            return back()->with('error', 'Invalid donor token. Please check your email for the correct link.');
        }

        if ($role === 'requester') {
            $token = trim($request->input('token', ''));
            $req   = DonationRequest::where('requester_token', $token)->first();
            if ($req) {
                return redirect()->route('track.requester', ['token' => $token]);
            }
            return back()->with('error', 'Invalid requester token. Please check your email for the correct link.');
        }

        return back()->with('error', 'Unknown role.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
