<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user()->role);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'role'        => 'required|in:donor,requester',
            'blood_group' => 'nullable|string|max:5',
            'phone'       => 'nullable|string|max:20',
            'location'    => 'nullable|string|max:200',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        // Auto-add donor to the Donor matching table when registering as a donor
        if ($validated['role'] === 'donor') {
            Donor::create([
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'blood_group' => $validated['blood_group'] ?? 'Unknown',
                'phone'       => $validated['phone'] ?? null,
                'location'    => $validated['location'] ?? 'Not specified',
                'latitude'    => $validated['latitude'] ?? 23.8103,
                'longitude'   => $validated['longitude'] ?? 90.4125,
                'status'      => 'Available',
                'initials'    => strtoupper(implode('', array_map(fn($w) => $w[0], array_filter(explode(' ', $validated['name']))))),
            ]);
        }

        Auth::login($user);

        return $this->redirectByRole($user->role);
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'donor'     => redirect()->route('donor.dashboard'),
            'requester' => redirect()->route('requester.dashboard'),
        };
    }
}
