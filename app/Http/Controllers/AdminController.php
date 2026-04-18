<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NidVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalDonors'     => User::where('role', 'donor')->count(),
            'totalRequesters' => User::where('role', 'requester')->count(),
            'pendingNid'      => NidVerification::where('status', 'pending')->count(),
            'recentUsers'     => User::whereIn('role', ['donor', 'requester'])->latest()->take(5)->get(),
        ]);
    }

    public function users()
    {
        $users = User::whereIn('role', ['donor', 'requester'])
                     ->with('nidVerification')
                     ->latest()
                     ->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function nidQueue()
    {
        $pending = NidVerification::where('status', 'pending')
                                  ->with('user')
                                  ->latest()
                                  ->get();
        return view('admin.nid-queue', compact('pending'));
    }

    public function verifyNid(NidVerification $nid)
    {
        $nid->update([
            'status'      => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        $this->notifyUser($nid, 'verified');
        return back()->with('success', 'NID verified successfully.');
    }

    public function rejectNid(NidVerification $nid)
    {
        $nid->update([
            'status'      => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        $this->notifyUser($nid, 'rejected');
        return back()->with('success', 'NID submission rejected.');
    }

    private function notifyUser(NidVerification $nid, string $status): void
    {
        if (!$nid->user || !$nid->user->email) return;

        $subject = $status === 'verified'
            ? '[bloodConnect] Your NID has been verified'
            : '[bloodConnect] Your NID submission was rejected';

        $message = $status === 'verified'
            ? "Hello {$nid->user->name},\n\nYour NID verification has been approved. You are now a verified member of bloodConnect."
            : "Hello {$nid->user->name},\n\nYour NID submission was rejected. Please re-submit with a clearer image of your National ID card.";

        try {
            Mail::raw($message, fn ($m) => $m->to($nid->user->email)->subject($subject));
        } catch (\Throwable $e) {
            \Log::error('NID notification email failed: ' . $e->getMessage());
        }
    }
}
