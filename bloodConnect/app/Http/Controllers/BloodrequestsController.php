<?php

namespace App\Http\Controllers;

use App\Models\bloodrequests;
use Illuminate\Http\Request;

class BloodrequestsController extends Controller
{
    public function create()
        {
            return view('find-blood');
        }

    public function store(Request $request)
        {
            // Validation logic
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

            // Handling the 'urgent' checkbox (converts to string for your DB preference)
            $validated['urgent'] = $request->has('urgent') ? 'Urgent' : '';

            if ($request->filled('latitude')) {
                $validated['latitude'] = $request->input('latitude');
            }
            if ($request->filled('longitude')) {
                $validated['longitude'] = $request->input('longitude');
            }

            // Save to Database
            bloodrequests::create($validated);

            return redirect()->route('home')->with('success', 'Blood request submitted successfully.');
        }

    public function index()
    {
        // Fetch the 5 most recent blood requests
        $announcements = bloodrequests::latest('created_at')->take(5)->get();

        // Fetch top 10 donors
        $topDonors = \App\Models\User::withCount(['donations as total_bags' => function ($query) {
            $query->selectRaw('sum(bags)');
        }])
        ->orderByDesc('total_bags')
        ->take(10)
        ->get();

        return view('welcome', compact('announcements', 'topDonors'));
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
