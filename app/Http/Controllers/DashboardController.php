<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Donor;
use App\Models\bloodrequests;

class DashboardController extends Controller
{
    
    private static array $COMPAT = [
        'O-'  => ['O-','O+','A-','A+','B-','B+','AB-','AB+'],
        'O+'  => ['O+','A+','B+','AB+'],
        'A-'  => ['A-','A+','AB-','AB+'],
        'A+'  => ['A+','AB+'],
        'B-'  => ['B-','B+','AB-','AB+'],
        'B+'  => ['B+','AB+'],
        'AB-' => ['AB-','AB+'],
        'AB+' => ['AB+'],
    ];

    public function index()
    {
        return view('dashboard');
    }

    public function getDonors(Request $request)
    {
        $query = Donor::query();

        if ($request->filled('blood_group')) {
            $bg = $request->blood_group;
            $compatible = collect(self::$COMPAT)->filter(fn($targets) => in_array($bg, $targets))->keys()->toArray();
            if ($compatible) $query->whereIn('blood_group', $compatible);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('available')) {
            $query->where('status', $request->available === '1' ? 'Available' : '!=', 'Available');
        }

        $page   = max(1, (int)($request->page ?? 1));
        $limit  = min(100, max(1, (int)($request->limit ?? 50)));
        $total  = $query->count();
        $donors = $query->skip(($page - 1) * $limit)->take($limit)->get()->map(function ($d) {
            $eligible = true;
            if ($d->last_donation) {
                $daysSince = now()->diffInDays($d->last_donation);
                $eligible  = $daysSince >= ($d->min_wait ?? 90);
            }
            $d->eligible     = $eligible;
            $d->days_since   = $d->last_donation ? now()->diffInDays($d->last_donation) : null;
            return $d;
        });

        return response()->json([
            'donors' => $donors,
            'total'  => $total,
            'page'   => $page,
            'limit'  => $limit,
        ]);
    }

    public function getDonor($id)
    {
        $donor = Donor::findOrFail($id);
        $care  = DB::table('donor_care')->where('donor_id', $id)->first();
        $donor->care = $care;
        $eligible = true;
        if ($donor->last_donation) {
            $eligible = now()->diffInDays($donor->last_donation) >= ($donor->min_wait ?? 90);
        }
        $donor->eligible   = $eligible;
        $donor->days_since = $donor->last_donation ? now()->diffInDays($donor->last_donation) : null;
        return response()->json($donor);
    }

    public function getCare($donorId)
    {
        $care = DB::table('donor_care')->where('donor_id', $donorId)->first();
        if (!$care) {
            return response()->json(['error' => 'No care schedule found'], 404);
        }
        return response()->json($care);
    }

    public function saveCare(Request $request)
    {
        $data = $request->validate([
            'donor_id'         => 'required|exists:donors,id',
            'hydration_start'  => 'required',
            'hydration_end'    => 'required',
            'rest_start'       => 'required',
            'rest_end'         => 'required',
            'nutrition_start'  => 'required',
            'nutrition_end'    => 'required',
        ]);
        DB::table('donor_care')->updateOrInsert(
            ['donor_id' => $data['donor_id']],
            array_merge($data, ['updated_at' => now()])
        );
        return response()->json(['success' => true]);
    }

    public function registerDonor(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'blood_group' => 'required|string|max:5',
            'location'    => 'required|string|max:200',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email',
        ]);
        $data['status'] = 'Available';
        $donor = Donor::create($data);
        return response()->json(['success' => true, 'donor' => $donor]);
    }

    public function getRequests(Request $request)
    {
        $query = bloodrequests::query();
        if ($request->filled('hospital')) $query->where('location', 'like', '%' . $request->hospital . '%');
        if ($request->filled('urgency'))  $query->where('urgent', $request->urgency === 'critical' ? 'Urgent' : '!=', 'Urgent');
        if ($request->filled('status'))   $query->where('urgent', $request->status);
        return response()->json($query->latest()->take(50)->get());
    }

    public function getConfirmations()
    {
        
        $donors = Donor::where('status', 'Available')->take(10)->get()->map(fn($d) => [
            'name'        => $d->name,
            'blood_group' => $d->blood_group,
            'phone'       => $d->phone ?? '',
            'location'    => $d->location ?? '',
        ]);
        return response()->json($donors);
    }

    public function getStats()
    {
        $totalDonors  = Donor::count();
        $availDonors  = Donor::where('status', 'Available')->count();
        $urgentReqs   = bloodrequests::where('urgent', 'Urgent')->count();

        $eligibleCount = Donor::all()->filter(function ($d) {
            if (!$d->last_donation) return true;
            return now()->diffInDays($d->last_donation) >= ($d->min_wait ?? 90);
        })->count();

        return response()->json([
            'total_donors'  => $totalDonors,
            'avail_donors'  => $availDonors,
            'urgent_reqs'   => $urgentReqs,
            'eligible'      => $eligibleCount,
        ]);
    }

    public function toggleAvailability(Request $request)
    {
        $donor = Donor::findOrFail($request->donor_id);
        $donor->status = $donor->status === 'Available' ? 'Unavailable' : 'Available';
        $donor->save();
        return response()->json(['success' => true, 'status' => $donor->status]);
    }

    public function addRequest(Request $request)
    {
        $data = $request->validate([
            'bloodgroup'  => 'required|string|max:5',
            'location'    => 'required|string',
            'noofbags'    => 'required|integer|min:1',
            'contactno'   => 'required|string',
        ]);
        $data['urgent']      = $request->input('urgent', '');
        $data['datetime']    = now()->addHour();
        $data['patienttype'] = $request->input('patienttype', 'Adult');
        $data['patientage']  = $request->input('patientage', 0);
        $data['patientgender'] = $request->input('patientgender', 'Unknown');
        $req = bloodrequests::create($data);
        return response()->json(['success' => true, 'request' => $req]);
    }

    public function updateRequestStatus(Request $request)
    {
        $req = bloodrequests::findOrFail($request->id);
        $req->urgent = $request->status ?? $req->urgent;
        $req->save();
        return response()->json(['success' => true]);
    }

    public function getAnalytics()
    {
        $byBloodGroup = bloodrequests::selectRaw('bloodgroup, COUNT(*) as total_requests, SUM(noofbags) as total_units')
            ->groupBy('bloodgroup')->get();

        $donorPool = [
            'total'     => Donor::count(),
            'available' => Donor::where('status', 'Available')->count(),
            'eligible'  => Donor::all()->filter(fn($d) => !$d->last_donation || now()->diffInDays($d->last_donation) >= 90)->count(),
        ];

        $donorStats = Donor::all()->map(fn($d) => [
            'name'          => $d->name,
            'blood_group'   => $d->blood_group,
            'last_donation' => $d->last_donation,
            'status'        => $d->status,
            'days_since'    => $d->last_donation ? now()->diffInDays($d->last_donation) : null,
        ]);

        return response()->json([
            'by_blood_group' => $byBloodGroup,
            'donor_pool'     => $donorPool,
            'donor_stats'    => $donorStats,
        ]);
    }
}
