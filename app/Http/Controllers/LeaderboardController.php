<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topDonors = User::withCount(['donations as total_bags' => function ($query) {
            $query->selectRaw('sum(bags)');
        }])
        ->orderByDesc('total_bags')
        ->take(10)
        ->get();

        return view('leaderboard', compact('topDonors'));
    }
}
