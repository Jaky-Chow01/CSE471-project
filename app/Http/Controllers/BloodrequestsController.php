<?php

namespace App\Http\Controllers;

use App\Models\bloodrequests;
use App\Models\DonationRequest;
use App\Models\NidVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BloodrequestsController extends Controller
{
    public function create()
        {
            return view('find-blood');
        }

    public function store(Request $request)
        {
            if (auth()->check() && auth()->user()->role === 'requester') {
                $nid = NidVerification::where('user_id', auth()->id())
                                       ->where('status', 'verified')
                                       ->first();
                if (!$nid) {
                    return back()->with('error', 'Your NID must be verified before you can submit a blood request.');
                }
            }

            $validated = $request->validate([
                'bloodgroup' => 'required',
                'location' => 'required|string',
                'datetime' => 'required|date|after:now',
                'noofbags' => 'required|integer|min:1',
                'patienttype' => 'required',
                'patientage' => 'required|integer|min:0',
                'patientgender' => 'required',
                'contactno' => 'required|string',
            ]);

            $validated['urgent'] = $request->has('urgent') ? 'Urgent' : '';

            if ($request->filled('latitude')) {
                $validated['latitude'] = $request->input('latitude');
            }
            if ($request->filled('longitude')) {
                $validated['longitude'] = $request->input('longitude');
            }

            $bloodRequest = bloodrequests::create($validated);

            do { $donorToken = Str::random(32); }
            while (DonationRequest::where('donor_token', $donorToken)->exists());

            do { $requesterToken = Str::random(32); }
            while (DonationRequest::where('requester_token', $requesterToken)->exists());

            DonationRequest::create([
                'stage'            => 0,
                'donor_token'      => $donorToken,
                'requester_token'  => $requesterToken,
                'bloodrequest_id'  => $bloodRequest->id,
                'user_id'          => auth()->id(),
            ]);

            return redirect()->route('blood.request.submitted', ['token' => $requesterToken]);
        }

    public function index()
    {
        
        $announcements = bloodrequests::latest('created_at')->take(5)->get();

        $topDonors = \App\Models\User::withCount(['donations as total_bags' => function ($query) {
            $query->selectRaw('sum(bags)');
        }])
        ->orderByDesc('total_bags')
        ->take(10)
        ->get();

        return view('welcome', compact('announcements', 'topDonors'));
    }

    public function submitted(string $token)
    {
        $donation = DonationRequest::where('requester_token', $token)->firstOrFail();
        return view('request-submitted', [
            'requesterToken' => $token,
            'requesterLink'  => route('track.requester', $token),
        ]);
    }

    public function editingbloodrequest(Request $request)
    {
        $temp=bloodrequests::findOrFail($request->id);
        $temp->urgent =$request->urgent; 
        $temp->bloodgroup=$request->bloodgroup;
        $temp->location=$request->location;
        $temp->datetim=$request->datetim;
        $temp->noofbags=$request->noofbags;
        $temp->patienttype=$request->patienttype;
        $temp->patientage=$request->patientage;
        $temp->patientgender=$request->patientgender;
        $temp->contactno=$request->contactno;  

        $temp->save() ;
        return response()->json('Blood Request Edited successfully!');
    }

    public function deletingbloodrequest(Request $request)
    {
        $temp=bloodrequests::findOrFail($request->id)->delete();

        return response()->json('Blood Request Deleted successfully!');
    }

    public function gettingbloodrequest()
    {
        $temp=bloodrequests::all();
    
        return response()->json($temp);
    }

}
