<?php

namespace App\Http\Controllers;

use App\Models\NidVerification;
use Illuminate\Http\Request;

class NidSubmissionController extends Controller
{
    public function show()
    {
        $existing = NidVerification::where('user_id', auth()->id())->first();
        return view('nid.submit', compact('existing'));
    }

    public function store(Request $request)
    {
        $existing = NidVerification::where('user_id', auth()->id())->first();

        if ($existing && in_array($existing->status, ['pending', 'verified'])) {
            return back()->with('error', 'A ' . $existing->status . ' NID submission already exists for your account.');
        }

        $validated = $request->validate([
            'full_name'  => 'required|string|max:150',
            'nid_number' => 'required|string|max:20',
            'nid_image'  => 'required|image|max:4096',
        ]);

        $path = $request->file('nid_image')->store('nid-submissions', 'public');

        NidVerification::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'full_name'   => $validated['full_name'],
                'nid_number'  => $validated['nid_number'],
                'image_path'  => $path,
                'status'      => 'pending',
                'verified_by' => null,
                'verified_at' => null,
            ]
        );

        return back()->with('success', 'NID submitted successfully. Awaiting admin review.');
    }
}
