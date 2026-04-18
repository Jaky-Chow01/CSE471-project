<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    public function calculateRoute(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
        ]);

        $apiKey = config('services.google.directions_api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'Google API key not configured'], 500);
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'key' => $apiKey,
            'mode' => 'driving', 
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['status'] === 'OK') {
                $route = $data['routes'][0];
                $leg = $route['legs'][0];
                return response()->json([
                    'distance' => $leg['distance']['text'],
                    'duration' => $leg['duration']['text'],
                    'steps' => $leg['steps'],
                ]);
            } else {
                return response()->json(['error' => 'No route found'], 404);
            }
        } else {
            return response()->json(['error' => 'Failed to fetch route'], 500);
        }
    }
}
