<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Requester Panel</title>
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
                <i class="fa-solid fa-person-half-dress mr-1 text-red-500 flex-shrink-0"></i><span class="truncate"><?php echo e(auth()->user()->name); ?></span>
            </span>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 mt-4 space-y-5">

        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Welcome, <?php echo e(auth()->user()->name); ?></h1>
            <p class="text-sm text-gray-500 mt-1">Your requester panel — track blood requests and verify your identity.</p>
        </div>

        <?php if($nid?->status === 'verified'): ?>
        <div class="bg-red-600 rounded-[2.5rem] shadow-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-white font-extrabold text-lg">Need blood urgently?</p>
                <p class="text-red-200 text-sm mt-1">Submit a blood request now — donors will be notified.</p>
            </div>
            <a href="<?php echo e(route('blood.request.create')); ?>"
               class="sm:flex-shrink-0 bg-white text-red-600 hover:bg-red-50 px-5 py-3 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg text-center">
                <i class="fa-solid fa-plus mr-1"></i>Request
            </a>
        </div>
        <?php else: ?>
        <div class="bg-gray-100 rounded-[2.5rem] shadow-xl p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border border-gray-200">
            <div>
                <p class="text-gray-700 font-extrabold text-lg">Need blood urgently?</p>
                <p class="text-gray-500 text-sm mt-1">
                    <?php if(!$nid): ?>
                        Submit your NID below to unlock blood requests.
                    <?php elseif($nid->status === 'pending'): ?>
                        Your NID is under review. You can request blood once verified.
                    <?php else: ?>
                        Your NID was rejected. Re-submit below to unlock blood requests.
                    <?php endif; ?>
                </p>
            </div>
            <div class="sm:flex-shrink-0 bg-gray-300 text-gray-500 px-5 py-3 rounded-2xl font-black text-sm text-center cursor-not-allowed select-none">
                <i class="fa-solid fa-lock mr-1"></i>Request
            </div>
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
            <p class="text-sm text-gray-500 mb-4">Submit your NID to become a verified member of the bloodConnect network.</p>
            <a href="<?php echo e(route('requester.nid')); ?>"
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
            <a href="<?php echo e(route('requester.nid')); ?>"
               class="inline-block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                <i class="fa-solid fa-rotate-right mr-2"></i>Re-submit NID
            </a>
            <?php endif; ?>
        </div>

        <?php if($requests->count() > 0): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Your Active Blood Requests</p>
            <div class="space-y-3">
                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-2xl">
                    <i class="fa-solid fa-heart-pulse text-red-500 w-4 flex-shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-red-700">Request #<?php echo e($req->id); ?></p>
                        <p class="text-[10px] text-gray-500">Stage: <?php echo e($req->stage); ?>/4 · <?php echo e($req->created_at->format('d M Y')); ?></p>
                    </div>
                    <a href="<?php echo e(route('track.requester', $req->requester_token)); ?>" target="_blank"
                       class="flex-shrink-0 text-[10px] px-3 py-1.5 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition">
                        Track
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <a href="<?php echo e(route('blood.banks')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-4 flex flex-col items-center gap-2 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-9 h-9 rounded-xl bg-red-100 group-hover:bg-red-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-hospital text-red-600 text-sm"></i>
                </div>
                <span class="text-xs font-black text-gray-700 text-center">Blood Banks</span>
            </a>
            <a href="<?php echo e(route('diagnostic.centers')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-4 flex flex-col items-center gap-2 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-9 h-9 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-flask text-blue-600 text-sm"></i>
                </div>
                <span class="text-xs font-black text-gray-700 text-center">Diagnostics</span>
            </a>
            <a href="<?php echo e(route('find.donors')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-4 flex flex-col items-center gap-2 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-map-location-dot text-emerald-600 text-sm"></i>
                </div>
                <span class="text-xs font-black text-gray-700 text-center">Find Donors</span>
            </a>
        </div>

    </div>
</body>
</html>
<?php  ?>
