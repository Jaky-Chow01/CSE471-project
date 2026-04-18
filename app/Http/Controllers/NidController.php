<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NidController extends Controller
{
    public function adminPortal()
    {
        $donor = [
            'name'  => 'ABC',
            'nid'   => '1992130154499',
            'dob'   => '12-05-1998',
            'email' => 'rameezah.rahman.yeasha@g.bracu.ac.bd',
        ];
        return view('nid_verify', compact('donor'));
    }

    public function upload(Request $request)
    {
        $file = $request->file('nid_image');
        if ($file) {
            $file->store('uploads', 'public');
            return response()->json(['status' => 'SUCCESS']);
        }
        return response()->json(['status' => 'ERROR']);
    }

    public function verify(Request $request)
    {
        $data = $request->json()->all();
        $nid  = $data['nid_number'] ?? '';

        if (str_starts_with($nid, '199')) {
            try {
                Mail::raw(
                    "Hello {$data['name']}, your NID is verified!",
                    fn ($m) => $m->to($data['email'])->subject('Verified!')
                );
                return response()->json(['status' => 'SUCCESS']);
            } catch (\Throwable $e) {
                return response()->json(['status' => 'SUCCESS', 'message' => 'Verified but Email Error']);
            }
        }

        return response()->json(['status' => 'FAILED']);
    }
}
