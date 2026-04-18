<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\DonationRequest;
use App\Models\BloodNotification;

class TrackingController extends Controller
{
    private const STAGE_INFO = [
        0 => [
            'label'          => 'Requested',
            'icon'           => 'fa-paper-plane',
            'donor_msg'      => 'A blood request has been submitted matching your blood type.',
            'requester_msg'  => 'Your request has been submitted. Searching for a donor…',
            'notification'   => 'A new blood donation request has been submitted.',
            'subject'        => 'Blood Request Submitted',
        ],
        1 => [
            'label'          => 'Accepted',
            'icon'           => 'fa-check',
            'donor_msg'      => 'You have accepted this request. The admin will confirm the match shortly.',
            'requester_msg'  => 'A donor has accepted your request. Admin is confirming the match.',
            'notification'   => 'A donor has accepted the blood request.',
            'subject'        => 'Donor Accepted — Blood Request Update',
        ],
        2 => [
            'label'          => 'Arrived',
            'icon'           => 'fa-hospital-user',
            'donor_msg'      => 'You have arrived at the hospital. Please check in at the front desk.',
            'requester_msg'  => 'The donor has arrived at the hospital.',
            'notification'   => 'The donor has arrived at the hospital.',
            'subject'        => 'Donor Arrived — Blood Request Update',
        ],
        3 => [
            'label'          => 'Matched',
            'icon'           => 'fa-vial-circle-check',
            'donor_msg'      => 'Blood type confirmed. Donation process is starting now.',
            'requester_msg'  => 'Blood type matched! Donation is in progress.',
            'notification'   => 'Blood type confirmed — donation is in progress.',
            'subject'        => 'Blood Matched — Donation In Progress',
        ],
        4 => [
            'label'          => 'Success',
            'icon'           => 'fa-heart',
            'donor_msg'      => 'Donation complete! Thank you for saving a life.',
            'requester_msg'  => 'Donation successful! The blood has been received.',
            'notification'   => 'Donation complete! Blood has been successfully received.',
            'subject'        => 'Donation Successful — Thank You!',
        ],
    ];

    public function adminView()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('login');
        }

        $req           = DonationRequest::latest()->first();
        $notifications = BloodNotification::orderByDesc('created_at')->limit(10)->get();
        $donor = [
            'name'  => 'ABC',
            'nid'   => '1992130154499',
            'dob'   => '12-05-1998',
            'email' => 'rameezah.rahman.yeasha@g.bracu.ac.bd',
        ];

        if (!$req) {
            return view('tracking', [
                'stage'          => 0,
                'stages'         => self::STAGE_INFO,
                'notifications'  => $notifications,
                'role'           => 'admin',
                'donor_link'     => null,
                'requester_link' => null,
                'empty'          => true,
                'donor'          => $donor,
            ]);
        }

        return view('tracking', [
            'stage'          => $req->stage,
            'stages'         => self::STAGE_INFO,
            'notifications'  => $notifications,
            'role'           => 'admin',
            'donor_link'     => route('track.donor', $req->donor_token),
            'requester_link' => route('track.requester', $req->requester_token),
            'donor'          => $donor,
        ]);
    }

    public function adminPanel()
    {
        $requests      = DonationRequest::with(['user', 'donorUser', 'bloodRequest'])->latest()->get();
        $notifications = BloodNotification::orderByDesc('created_at')->limit(20)->get();
        return view('admin.track', [
            'requests'      => $requests,
            'stages'        => self::STAGE_INFO,
            'notifications' => $notifications,
            'baseUrl'       => url(''),
        ]);
    }

    public function donorView(string $token)
    {
        $req = DonationRequest::where('donor_token', $token)->firstOrFail();
        return view('tracking', [
            'stage'          => $req->stage,
            'stages'         => self::STAGE_INFO,
            'notifications'  => [],
            'role'           => 'donor',
            'donor_link'     => null,
            'requester_link' => null,
        ]);
    }

    public function requesterView(string $token)
    {
        $req = DonationRequest::where('requester_token', $token)->firstOrFail();
        return view('tracking', [
            'stage'          => $req->stage,
            'stages'         => self::STAGE_INFO,
            'notifications'  => [],
            'role'           => 'requester',
            'donor_link'     => null,
            'requester_link' => null,
        ]);
    }

    public function updateStage(int $id, int $newStage)
    {
        if (!array_key_exists($newStage, self::STAGE_INFO)) {
            return redirect()->route('admin.track');
        }

        $req        = DonationRequest::with(['user', 'donorUser', 'bloodRequest'])->findOrFail($id);
        $req->stage = $newStage;
        $req->save();

        $this->sendInApp($newStage);
        $this->sendEmail($newStage, $req);

        return redirect()->route('admin.track');
    }

    private function sendInApp(int $stage): void
    {
        $info = self::STAGE_INFO[$stage];
        BloodNotification::create([
            'stage'   => $stage,
            'channel' => 'in-app',
            'message' => $info['notification'],
            'status'  => 'delivered',
        ]);
    }

    private function sendEmail(int $stage, DonationRequest $req): void
    {
        $info           = self::STAGE_INFO[$stage];
        $requesterEmail = $req->user?->email ?? env('REQUESTER_EMAIL', 'requester@example.com');
        $donorEmail     = $req->donorUser?->email ?? env('DONOR_EMAIL', 'donor@example.com');

        try {
            Mail::raw(
                "Blood Connect Update — Stage: {$info['label']}\n\n{$info['requester_msg']}\n\nTrack live: " . route('track.requester', $req->requester_token),
                fn ($m) => $m->to($requesterEmail)->subject("[Blood Connect] {$info['subject']}")
            );
            Mail::raw(
                "Blood Connect Update — Stage: {$info['label']}\n\n{$info['donor_msg']}\n\nTrack live: " . route('track.donor', $req->donor_token),
                fn ($m) => $m->to($donorEmail)->subject("[Blood Connect] {$info['subject']}")
            );
            BloodNotification::create([
                'stage'   => $stage,
                'channel' => 'email',
                'message' => "Email sent: {$info['subject']}",
                'status'  => 'sent',
            ]);
        } catch (\Throwable $e) {
            BloodNotification::create([
                'stage'   => $stage,
                'channel' => 'email',
                'message' => 'Email failed: ' . substr($e->getMessage(), 0, 100),
                'status'  => 'failed',
            ]);
        }
    }
}
