<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\DonationRequest;
use App\Models\NidVerification;
use App\Models\BloodNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class DonorController extends Controller
{
    public function home()
    {
        return view('find-donors');
    }

    public function acceptRequest(int $id)
    {
        $req = DonationRequest::with(['user', 'bloodRequest'])->findOrFail($id);

        if ($req->stage !== 0 || $req->donor_user_id !== null) {
            return back()->with('error', 'This request is no longer available.');
        }

        $nid = NidVerification::where('user_id', auth()->id())
                               ->where('status', 'verified')
                               ->first();
        if (!$nid) {
            return back()->with('error', 'Your NID must be verified before you can accept donation requests.');
        }

        $req->update(['donor_user_id' => auth()->id(), 'stage' => 1]);

        BloodNotification::create([
            'stage'   => 1,
            'channel' => 'in-app',
            'message' => 'Donor ' . auth()->user()->name . ' accepted a blood request.',
            'status'  => 'delivered',
        ]);

        $this->notifyAccepted($req);

        return redirect()->route('donor.dashboard')
                         ->with('success', 'You have accepted the request. Please await confirmation from the admin.');
    }

    private function notifyAccepted(DonationRequest $req): void
    {
        $baseUrl    = config('app.url');
        $donorName  = auth()->user()->name;
        $bloodGroup = $req->bloodRequest?->bloodgroup ?? 'N/A';

        if ($req->user?->email) {
            try {
                Mail::raw(
                    "Blood Connect Update\n\nDonor {$donorName} has accepted your blood request for {$bloodGroup}.\n\nAdmin is reviewing the match. Track live: {$baseUrl}/track/requester/{$req->requester_token}",
                    fn($m) => $m->to($req->user->email)->subject('[Blood Connect] A Donor Has Accepted Your Request')
                );
                BloodNotification::create(['stage' => 1, 'channel' => 'email', 'message' => 'Email sent to requester: donor accepted', 'status' => 'sent']);
            } catch (\Throwable $e) {
                BloodNotification::create(['stage' => 1, 'channel' => 'email', 'message' => 'Requester email failed: ' . substr($e->getMessage(), 0, 80), 'status' => 'failed']);
            }
        }

        $adminEmail = User::where('role', 'admin')->value('email');
        if ($adminEmail) {
            try {
                Mail::raw(
                    "Blood Connect — Action Required\n\nDonor {$donorName} has accepted a blood request (blood group: {$bloodGroup}).\n\nPlease confirm the match in the admin panel: {$baseUrl}/admin/track",
                    fn($m) => $m->to($adminEmail)->subject('[Blood Connect] Donor Accepted — Please Confirm Match')
                );
                BloodNotification::create(['stage' => 1, 'channel' => 'email', 'message' => 'Email sent to admin: action required', 'status' => 'sent']);
            } catch (\Throwable $e) {
                BloodNotification::create(['stage' => 1, 'channel' => 'email', 'message' => 'Admin email failed: ' . substr($e->getMessage(), 0, 80), 'status' => 'failed']);
            }
        }
    }

    public function search(Request $request)
    {
        $bg      = $request->query('blood_group');
        $userLat = (float) $request->query('lat', 23.8103);
        $userLng = (float) $request->query('lng', 90.4125);

        $donors  = Donor::where('blood_group', $bg)->where('status', 'Available')->get();

        $results = $donors->map(function ($d) use ($userLat, $userLng) {
            $distKm = $this->haversine($userLat, $userLng, $d->latitude, $d->longitude);
            return [
                'name'        => $d->name,
                'location'    => ['lat' => $d->latitude, 'lng' => $d->longitude],
                'distance'    => round($distKm, 2) . ' km',
                'travel_time' => max(5, round(($distKm / 20) * 60)) . ' mins',
                '_dist'       => $distKm,
            ];
        })->sortBy('_dist')->values()->map(function ($d) {
            unset($d['_dist']);
            return $d;
        });

        return response()->json(['donors_found' => $results]);
    }

    private function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
        return $R * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
