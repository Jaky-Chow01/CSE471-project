<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Donor Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen pb-20 relative">
    <div class="blood-particle" style="width:20px;height:20px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:35px;height:35px;left:75%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-4xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <span class="hidden sm:flex text-xs text-gray-400 font-mono bg-white/70 px-3 py-1.5 rounded-2xl border border-white items-center max-w-[160px] truncate">
                <i class="fa-solid fa-user-nurse mr-1 text-blue-500 flex-shrink-0"></i><span class="truncate"><?php echo e(auth()->user()->name); ?></span>
            </span>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 mt-4 space-y-5">

        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Welcome, <?php echo e(auth()->user()->name); ?></h1>
            <p class="text-sm text-gray-500 mt-1">Your donor panel — respond to blood requests and track your donations.</p>
        </div>

        <?php if(session('success')): ?>
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-3">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            <p class="text-sm font-bold text-emerald-700"><?php echo e(session('success')); ?></p>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-5 py-3">
            <i class="fa-solid fa-circle-xmark text-red-500"></i>
            <p class="text-sm font-bold text-red-700"><?php echo e(session('error')); ?></p>
        </div>
        <?php endif; ?>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Identity Verification (NID)</p>
                <?php if(!$nid): ?>
                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">Not Submitted</span>
                <?php elseif($nid->status === 'verified'): ?>
                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700"><i class="fa-solid fa-check mr-1"></i>Verified</span>
                <?php elseif($nid->status === 'pending'): ?>
                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-amber-100 text-amber-700"><i class="fa-solid fa-clock mr-1"></i>Pending Review</span>
                <?php else: ?>
                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-red-100 text-red-700"><i class="fa-solid fa-xmark mr-1"></i>Rejected</span>
                <?php endif; ?>
            </div>

            <?php if(!$nid): ?>
            <p class="text-sm text-gray-500 mb-4">Verify your identity to start accepting blood donation requests.</p>
            <a href="<?php echo e(route('donor.nid')); ?>"
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                <i class="fa-solid fa-id-card mr-2"></i>Submit NID
            </a>
            <?php elseif($nid->status === 'verified'): ?>
            <div class="flex items-center gap-3 p-3 bg-emerald-50 border border-emerald-200 rounded-2xl">
                <i class="fa-solid fa-shield-check text-emerald-600 text-xl"></i>
                <div>
                    <p class="text-sm font-black text-emerald-700">Identity Verified</p>
                    <p class="text-xs text-emerald-600">Verified on <?php echo e($nid->verified_at?->format('d M Y') ?? 'N/A'); ?></p>
                </div>
            </div>
            <?php elseif($nid->status === 'pending'): ?>
            <div class="flex items-center gap-3 p-3 bg-amber-50 border border-amber-200 rounded-2xl">
                <i class="fa-solid fa-clock text-amber-500 text-xl"></i>
                <div>
                    <p class="text-sm font-black text-amber-700">Under Review</p>
                    <p class="text-xs text-amber-600">Submitted on <?php echo e($nid->created_at->format('d M Y')); ?>. Admin will review shortly.</p>
                </div>
            </div>
            <?php else: ?>
            <p class="text-sm text-gray-500 mb-4">Your previous submission was rejected. Please re-submit with a clearer NID image.</p>
            <a href="<?php echo e(route('donor.nid')); ?>"
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                <i class="fa-solid fa-rotate-right mr-2"></i>Re-submit NID
            </a>
            <?php endif; ?>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Open Blood Requests</p>
                <?php if($openRequests->count() > 0): ?>
                <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-red-100 text-red-700">
                    <?php echo e($openRequests->count()); ?> waiting
                </span>
                <?php endif; ?>
            </div>

            <?php if($nid?->status !== 'verified'): ?>
            <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                <p class="text-sm text-amber-700">You need a <span class="font-black">verified NID</span> to accept donation requests. Submit your NID above to get started.</p>
            </div>
            <?php elseif($openRequests->isEmpty()): ?>
            <div class="text-center py-8">
                <i class="fa-solid fa-inbox text-gray-300 text-3xl mb-3"></i>
                <p class="text-sm font-bold text-gray-500">No open requests right now</p>
                <p class="text-xs text-gray-400 mt-1">Check back soon — new requests appear here automatically.</p>
            </div>
            <?php else: ?>
            <div class="space-y-3">
                <?php $__currentLoopData = $openRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border border-gray-200 rounded-2xl p-4 bg-white hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-black text-red-600"><?php echo e($req->bloodRequest?->bloodgroup ?? '?'); ?></span>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-800"><?php echo e($req->bloodRequest?->bloodgroup ?? 'Unknown'); ?> Blood Needed</p>
                                <p class="text-xs text-gray-500">
                                    <i class="fa-solid fa-location-dot mr-1"></i><?php echo e($req->bloodRequest?->location ?? 'N/A'); ?>

                                    &nbsp;·&nbsp;
                                    <i class="fa-solid fa-droplet mr-1"></i><?php echo e($req->bloodRequest?->noofbags ?? '?'); ?> bag(s)
                                </p>
                                <?php if($req->bloodRequest?->urgent === 'Urgent'): ?>
                                <span class="inline-block mt-1 text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-red-600 text-white">Urgent</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <form method="POST" action="<?php echo e(route('donor.request.accept', $req->id)); ?>" class="flex-shrink-0">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-black rounded-xl transition active:scale-95 shadow-md shadow-red-200"
                                onclick="return confirm('Accept this blood donation request?')">
                                <i class="fa-solid fa-hand-holding-heart mr-1"></i>Accept
                            </button>
                        </form>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex flex-wrap items-center gap-2 sm:gap-4 text-[10px] text-gray-400">
                        <span><i class="fa-solid fa-calendar mr-1"></i><?php echo e($req->bloodRequest?->datetime ? \Carbon\Carbon::parse($req->bloodRequest->datetime)->format('d M Y, H:i') : 'N/A'); ?></span>
                        <span><i class="fa-solid fa-person mr-1"></i><?php echo e(ucfirst($req->bloodRequest?->patienttype ?? 'N/A')); ?>, <?php echo e($req->bloodRequest?->patientage ?? '?'); ?> yrs</span>
                        <span class="sm:ml-auto">Request #<?php echo e($req->id); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if($myRequests->count() > 0): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">My Accepted Donations</p>
            <div class="space-y-3">
                <?php $__currentLoopData = $myRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $stageLabels = ['Requested','Accepted','Confirmed','Arrived','Complete'];
                    $stageColors = ['gray','blue','purple','amber','emerald'];
                    $color = $stageColors[$req->stage] ?? 'gray';
                ?>
                <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-2xl">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-[10px] font-black text-blue-700"><?php echo e($req->bloodRequest?->bloodgroup ?? '?'); ?></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-blue-700">Donation #<?php echo e($req->id); ?></p>
                        <p class="text-[10px] text-gray-500">
                            Stage <?php echo e($req->stage); ?>/4 — <?php echo e($stageLabels[$req->stage] ?? 'Unknown'); ?>

                            · <?php echo e($req->created_at->format('d M Y')); ?>

                        </p>
                    </div>
                    <a href="<?php echo e(route('track.donor', $req->donor_token)); ?>" target="_blank"
                       class="flex-shrink-0 text-[10px] px-3 py-1.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                        <i class="fa-solid fa-route mr-1"></i>Track
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-2 gap-4">
            <a href="<?php echo e(route('find.donors')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-10 h-10 rounded-2xl bg-red-100 group-hover:bg-red-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-map-location-dot text-red-600"></i>
                </div>
                <span class="text-sm font-black text-gray-700">Find Donors</span>
            </a>
            <a href="<?php echo e(route('blood.types')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-droplet text-blue-600"></i>
                </div>
                <span class="text-sm font-black text-gray-700">Blood Types</span>
            </a>
        </div>

    </div>
</body>
</html>
<?php  ?>
