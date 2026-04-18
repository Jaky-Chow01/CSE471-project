<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;

class DonorController extends Controller
{
    public function home()
    {
        return view('map_search');
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
