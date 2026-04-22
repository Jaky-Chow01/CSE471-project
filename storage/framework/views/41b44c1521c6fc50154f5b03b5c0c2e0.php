<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Donation Tracking</title>
    <meta http-equiv="refresh" content="15">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen pb-20 relative">
    <div class="blood-particle" style="width:20px;height:20px;left:8%;animation-duration:22s;"></div>
    <div class="blood-particle" style="width:40px;height:40px;left:80%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-5xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">Dashboard</a>
            <a href="<?php echo e(route('admin.nid')); ?>" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">NID Queue</a>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 space-y-5 mt-2">

        <div class="flex flex-wrap items-start sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-gray-800">Donation Tracking</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage all active blood donation requests. Auto-refreshes every 15s.</p>
            </div>
            <div class="flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-black uppercase px-3 py-1.5 rounded-full flex-shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>Live
            </div>
        </div>

        <?php if($requests->isEmpty()): ?>
        <div class="bg-amber-50 border border-amber-200 rounded-[2.5rem] p-10 text-center">
            <i class="fa-solid fa-inbox text-amber-400 text-4xl mb-3"></i>
            <h2 class="text-lg font-extrabold text-amber-700">No donation requests yet</h2>
            <p class="text-sm text-amber-600 mt-1">Requests will appear here once submitted via <a href="<?php echo e(route('blood.request.create')); ?>" class="underline font-bold">Find Blood</a>.</p>
        </div>
        <?php else: ?>

        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $bg        = $req->bloodRequest?->bloodgroup ?? '?';
            $location  = $req->bloodRequest?->location ?? 'N/A';
            $bags      = $req->bloodRequest?->noofbags ?? '?';
            $urgent    = $req->bloodRequest?->urgent === 'Urgent';
            $stage     = $req->stage;
            $stageInfo = $stages[$stage];
            $donorLink     = "{$baseUrl}/track/donor/{$req->donor_token}";
            $requesterLink = "{$baseUrl}/track/requester/{$req->requester_token}";
        ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl overflow-hidden">

            <div class="px-4 sm:px-6 pt-5 pb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-black text-red-700"><?php echo e($bg); ?></span>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-base font-extrabold text-gray-800"><?php echo e($bg); ?> Blood — Request #<?php echo e($req->id); ?></p>
                            <?php if($urgent): ?>
                            <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded-full bg-red-600 text-white">Urgent</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-gray-500 truncate">
                            <i class="fa-solid fa-location-dot mr-1"></i><?php echo e($location); ?>

                            &nbsp;·&nbsp;
                            <i class="fa-solid fa-droplet mr-1"></i><?php echo e($bags); ?> bag(s)
                            &nbsp;·&nbsp;
                            <?php echo e($req->created_at->format('d M Y, H:i')); ?>

                        </p>
                    </div>
                </div>
                
                <?php
                    $badgeClass = match($stage) {
                        0 => 'bg-gray-100 text-gray-600',
                        1 => 'bg-blue-100 text-blue-700',
                        2 => 'bg-purple-100 text-purple-700',
                        3 => 'bg-amber-100 text-amber-700',
                        4 => 'bg-emerald-100 text-emerald-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                ?>
                <span class="flex-shrink-0 text-[10px] font-black uppercase px-3 py-1.5 rounded-full <?php echo e($badgeClass); ?>">
                    <i class="fa-solid <?php echo e($stageInfo['icon']); ?> mr-1"></i><?php echo e($stageInfo['label']); ?>

                </span>
            </div>

            <div class="px-6 py-5 space-y-5">

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-red-50 border border-red-100 rounded-2xl">
                        <p class="text-[9px] font-black uppercase tracking-widest text-red-400 mb-1">Requester</p>
                        <p class="text-sm font-bold text-gray-800"><?php echo e($req->user?->name ?? 'Unknown'); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($req->user?->email ?? '—'); ?></p>
                    </div>
                    <div class="p-3 <?php echo e($req->donorUser ? 'bg-blue-50 border border-blue-100' : 'bg-gray-50 border border-gray-100'); ?> rounded-2xl">
                        <p class="text-[9px] font-black uppercase tracking-widest <?php echo e($req->donorUser ? 'text-blue-400' : 'text-gray-400'); ?> mb-1">Donor</p>
                        <?php if($req->donorUser): ?>
                        <p class="text-sm font-bold text-gray-800"><?php echo e($req->donorUser->name); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($req->donorUser->email); ?></p>
                        <?php else: ?>
                        <p class="text-sm font-bold text-gray-400">Awaiting acceptance</p>
                        <p class="text-xs text-gray-400">No donor yet</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <div class="relative flex items-start justify-between">
                        <div class="absolute left-0 top-4 w-full h-1 bg-gray-200 rounded-full"></div>
                        <div class="absolute left-0 top-4 h-1 bg-emerald-500 rounded-full transition-all duration-700"
                             style="width: <?php echo e($stage * 25); ?>%"></div>
                        <?php for($i = 0; $i < 5; $i++): ?>
                        <?php $si = $stages[$i]; ?>
                        <div class="relative z-10 flex flex-col items-center w-1/5">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center border-2 transition-all duration-300
                                <?php echo e($stage >= $i ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-200' : 'bg-white border-gray-200 text-gray-300'); ?>">
                                <i class="fa-solid <?php echo e($si['icon']); ?> text-[10px]"></i>
                            </div>
                            <span class="mt-2 text-[8px] font-black uppercase text-center tracking-wide
                                <?php echo e($stage >= $i ? 'text-emerald-600' : 'text-gray-400'); ?>">
                                <?php echo e($si['label']); ?>

                            </span>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div class="flex items-center gap-2 p-2 bg-blue-50 border border-blue-100 rounded-xl">
                        <i class="fa-solid fa-user-nurse text-blue-400 text-xs flex-shrink-0"></i>
                        <a href="<?php echo e($donorLink); ?>" target="_blank" class="text-[10px] text-blue-600 underline truncate flex-1">Donor link</a>
                        <button onclick="navigator.clipboard.writeText('<?php echo e($donorLink); ?>')"
                            class="flex-shrink-0 text-[9px] px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-bold transition">Copy</button>
                    </div>
                    <div class="flex items-center gap-2 p-2 bg-red-50 border border-red-100 rounded-xl">
                        <i class="fa-solid fa-person-half-dress text-red-400 text-xs flex-shrink-0"></i>
                        <a href="<?php echo e($requesterLink); ?>" target="_blank" class="text-[10px] text-red-600 underline truncate flex-1">Requester link</a>
                        <button onclick="navigator.clipboard.writeText('<?php echo e($requesterLink); ?>')"
                            class="flex-shrink-0 text-[9px] px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-bold transition">Copy</button>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1 border-t border-gray-100 flex-wrap">
                    <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 mr-1">Admin Actions:</span>

                    <?php if($stage === 0): ?>
                    <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-2xl text-xs font-bold cursor-default">
                        <i class="fa-solid fa-clock mr-1"></i>Waiting for donor
                    </span>
                    <?php endif; ?>

                    <?php if($stage === 1): ?>
                    <a href="<?php echo e(route('admin.update.stage', [$req->id, 2])); ?>"
                       class="px-4 py-2 bg-purple-600 text-white rounded-2xl text-xs font-black hover:bg-purple-700 transition shadow-md shadow-purple-200"
                       onclick="return confirm('Mark donor as arrived at hospital for request #<?php echo e($req->id); ?>?')">
                        <i class="fa-solid fa-hospital-user mr-1"></i>Mark Arrived
                    </a>
                    <?php endif; ?>

                    <?php if($stage === 2): ?>
                    <a href="<?php echo e(route('admin.update.stage', [$req->id, 3])); ?>"
                       class="px-4 py-2 bg-amber-500 text-white rounded-2xl text-xs font-black hover:bg-amber-600 transition shadow-md shadow-amber-200"
                       onclick="return confirm('Confirm blood type matched for request #<?php echo e($req->id); ?>?')">
                        <i class="fa-solid fa-vial-circle-check mr-1"></i>Mark Matched
                    </a>
                    <?php endif; ?>

                    <?php if($stage === 3): ?>
                    <a href="<?php echo e(route('admin.update.stage', [$req->id, 4])); ?>"
                       class="px-4 py-2 bg-emerald-600 text-white rounded-2xl text-xs font-black hover:bg-emerald-700 transition shadow-md shadow-emerald-200"
                       onclick="return confirm('Mark donation as complete for request #<?php echo e($req->id); ?>?')">
                        <i class="fa-solid fa-heart mr-1"></i>Donation Complete
                    </a>
                    <?php endif; ?>

                    <?php if($stage === 4): ?>
                    <span class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-2xl text-xs font-black">
                        <i class="fa-solid fa-circle-check mr-1"></i>Completed
                    </span>
                    <?php endif; ?>

                    <?php if($stage > 0): ?>
                    <a href="<?php echo e(route('admin.update.stage', [$req->id, 0])); ?>"
                       class="ml-auto px-3 py-2 bg-white border border-gray-300 rounded-2xl text-xs font-bold text-gray-500 hover:bg-gray-50 transition"
                       onclick="return confirm('Reset request #<?php echo e($req->id); ?> back to stage 0?')">
                        <i class="fa-solid fa-rotate-left mr-1 text-gray-400"></i>Reset
                    </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php endif; ?>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Notification Log</p>
                <span class="text-[10px] text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Latest 20</span>
            </div>
            <?php if($notifications->count() > 0): ?>
            <div class="space-y-2 max-h-72 overflow-y-auto">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-start gap-3 p-3 rounded-2xl <?php echo e(in_array($notif->status, ['sent','delivered']) ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200'); ?>">
                    <div class="mt-0.5 flex-shrink-0">
                        <?php if($notif->channel === 'email'): ?>
                        <i class="fa-solid fa-envelope text-blue-500 text-sm"></i>
                        <?php else: ?>
                        <i class="fa-solid fa-bell text-amber-500 text-sm"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[10px] font-black uppercase tracking-wide text-gray-600"><?php echo e($notif->channel); ?></span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold <?php echo e(in_array($notif->status,['sent','delivered']) ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'); ?>"><?php echo e($notif->status); ?></span>
                            <span class="text-[10px] text-gray-400 ml-auto">Stage <?php echo e($notif->stage); ?> · <?php echo e(\Carbon\Carbon::parse($notif->created_at)->format('H:i d M')); ?></span>
                        </div>
                        <p class="text-xs text-gray-600 mt-0.5 truncate"><?php echo e($notif->message); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <p class="text-sm text-gray-400 text-center py-6">No notifications yet.</p>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
<?php  ?>
