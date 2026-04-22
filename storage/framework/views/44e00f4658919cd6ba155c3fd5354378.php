<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Live Tracking</title>
    <meta http-equiv="refresh" content="10">
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

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-4xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <?php if($role === 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">Admin Panel</a>
                <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="text-sm font-bold text-gray-500 hover:text-red-600 bg-white/70 px-4 py-2 rounded-2xl border border-white transition">
                    <i class="fa-solid fa-right-from-bracket mr-1"></i>Exit
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 space-y-5 mt-2">

        <?php if($role === 'donor'): ?>
        <div class="flex flex-wrap items-center gap-3 bg-blue-50/80 backdrop-blur-sm border border-blue-200 rounded-[2rem] px-4 sm:px-6 py-4">
            <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-user-nurse text-blue-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Donor Portal</p>
                <p class="text-sm font-bold text-gray-700">You are viewing your donor tracking page</p>
            </div>
            <div class="flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-black uppercase px-3 py-1 rounded-full flex-shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>Live
            </div>
        </div>
        <?php elseif($role === 'requester'): ?>
        <div class="flex flex-wrap items-center gap-3 bg-red-50/80 backdrop-blur-sm border border-red-200 rounded-[2rem] px-4 sm:px-6 py-4">
            <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-person-half-dress text-red-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest text-red-400">Requester Portal</p>
                <p class="text-sm font-bold text-gray-700">You are viewing your requester tracking page</p>
            </div>
            <div class="flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-black uppercase px-3 py-1 rounded-full flex-shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>Live
            </div>
        </div>
        <?php else: ?>
        <div class="flex flex-wrap items-center gap-3 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-[2rem] px-4 sm:px-6 py-4">
            <div class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-shield-halved text-gray-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Admin View</p>
                <p class="text-sm font-bold text-gray-700">Showing both donor and requester perspectives</p>
            </div>
            <div class="flex items-center gap-1.5 bg-green-100 text-green-700 text-[10px] font-black uppercase px-3 py-1 rounded-full flex-shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span>Live
            </div>
        </div>

        <?php endif; ?>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-8 text-center">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Current Stage</p>
            <h2 class="text-4xl font-extrabold text-red-600"><?php echo e($stages[$stage]['label']); ?></h2>
            <p class="text-sm text-gray-500 mt-2">Step <?php echo e($stage + 1); ?> of 5 &nbsp;·&nbsp; Live synchronization active</p>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-6 sm:p-8">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 text-center mb-8">Donation Progress</p>
            <div class="relative flex items-start justify-between">
                <div class="absolute left-0 top-5 w-full h-1 bg-gray-200 rounded-full"></div>
                <div class="absolute left-0 top-5 h-1 bg-emerald-500 rounded-full transition-all duration-700" style="width: <?php echo e($stage * 25); ?>%"></div>
                <?php for($i = 0; $i < 5; $i++): ?>
                <?php $info = $stages[$i]; ?>
                <div class="relative z-10 flex flex-col items-center w-1/5">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-2xl flex items-center justify-center border-2 transition-all duration-300
                        <?php echo e($stage >= $i ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-white border-gray-200 text-gray-300'); ?>">
                        <i class="fa-solid <?php echo e($info['icon']); ?> text-xs"></i>
                    </div>
                    <span class="mt-2 text-[8px] sm:text-[10px] font-black uppercase text-center tracking-wide leading-tight
                        <?php echo e($stage >= $i ? 'text-emerald-600' : 'text-gray-400'); ?>">
                        <?php echo e($info['label']); ?>

                    </span>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <?php if($role === 'donor'): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-blue-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center"><i class="fa-solid fa-user-nurse text-blue-600"></i></div>
                <div><p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Your Progress</p><p class="text-sm font-bold text-gray-700">What's happening on your end</p></div>
            </div>
            <div class="space-y-3">
                <?php for($i = 0; $i < 5; $i++): ?>
                <?php $info = $stages[$i]; ?>
                <div class="flex items-start gap-3 p-4 rounded-2xl <?php echo e($stage === $i ? 'bg-blue-50 border border-blue-200' : ($stage < $i ? 'opacity-40' : 'bg-gray-50')); ?>">
                    <div class="mt-0.5 w-6 h-6 rounded-lg flex-shrink-0 flex items-center justify-center text-[10px] font-black
                        <?php echo e($stage >= $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                        <?php if($stage > $i): ?><i class="fa-solid fa-check"></i><?php elseif($stage === $i): ?><i class="fa-solid fa-circle-dot"></i><?php else: ?><?php echo e($i + 1); ?><?php endif; ?>
                    </div>
                    <div><p class="text-xs font-black <?php echo e($stage === $i ? 'text-blue-700' : 'text-gray-600'); ?>"><?php echo e($info['label']); ?></p><p class="text-xs text-gray-500 leading-relaxed mt-0.5"><?php echo e($info['donor_msg']); ?></p></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <?php elseif($role === 'requester'): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-red-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center"><i class="fa-solid fa-person-half-dress text-red-600"></i></div>
                <div><p class="text-[10px] font-black uppercase tracking-widest text-red-400">Your Progress</p><p class="text-sm font-bold text-gray-700">What's happening with your request</p></div>
            </div>
            <div class="space-y-3">
                <?php for($i = 0; $i < 5; $i++): ?>
                <?php $info = $stages[$i]; ?>
                <div class="flex items-start gap-3 p-4 rounded-2xl <?php echo e($stage === $i ? 'bg-red-50 border border-red-200' : ($stage < $i ? 'opacity-40' : 'bg-gray-50')); ?>">
                    <div class="mt-0.5 w-6 h-6 rounded-lg flex-shrink-0 flex items-center justify-center text-[10px] font-black
                        <?php echo e($stage >= $i ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                        <?php if($stage > $i): ?><i class="fa-solid fa-check"></i><?php elseif($stage === $i): ?><i class="fa-solid fa-circle-dot"></i><?php else: ?><?php echo e($i + 1); ?><?php endif; ?>
                    </div>
                    <div><p class="text-xs font-black <?php echo e($stage === $i ? 'text-red-700' : 'text-gray-600'); ?>"><?php echo e($info['label']); ?></p><p class="text-xs text-gray-500 leading-relaxed mt-0.5"><?php echo e($info['requester_msg']); ?></p></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-blue-100 p-6">
                <div class="flex items-center gap-3 mb-4"><div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center"><i class="fa-solid fa-user-nurse text-blue-600 text-xs"></i></div><p class="text-xs font-black text-blue-500 uppercase tracking-widest">Donor View</p></div>
                <div class="space-y-2">
                    <?php for($i = 0; $i < 5; $i++): ?> <?php $info = $stages[$i]; ?>
                    <div class="flex items-start gap-2 p-3 rounded-xl <?php echo e($stage === $i ? 'bg-blue-50 border border-blue-200' : ($stage < $i ? 'opacity-40' : '')); ?>">
                        <div class="mt-0.5 w-5 h-5 rounded-md flex-shrink-0 flex items-center justify-center text-[9px] font-black <?php echo e($stage >= $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                            <?php if($stage > $i): ?><i class="fa-solid fa-check"></i><?php elseif($stage === $i): ?><i class="fa-solid fa-circle-dot"></i><?php else: ?><?php echo e($i + 1); ?><?php endif; ?>
                        </div>
                        <div><p class="text-[10px] font-black <?php echo e($stage === $i ? 'text-blue-700' : 'text-gray-600'); ?>"><?php echo e($info['label']); ?></p><p class="text-[10px] text-gray-500"><?php echo e($info['donor_msg']); ?></p></div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-red-100 p-6">
                <div class="flex items-center gap-3 mb-4"><div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center"><i class="fa-solid fa-person-half-dress text-red-600 text-xs"></i></div><p class="text-xs font-black text-red-500 uppercase tracking-widest">Requester View</p></div>
                <div class="space-y-2">
                    <?php for($i = 0; $i < 5; $i++): ?> <?php $info = $stages[$i]; ?>
                    <div class="flex items-start gap-2 p-3 rounded-xl <?php echo e($stage === $i ? 'bg-red-50 border border-red-200' : ($stage < $i ? 'opacity-40' : '')); ?>">
                        <div class="mt-0.5 w-5 h-5 rounded-md flex-shrink-0 flex items-center justify-center text-[9px] font-black <?php echo e($stage >= $i ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                            <?php if($stage > $i): ?><i class="fa-solid fa-check"></i><?php elseif($stage === $i): ?><i class="fa-solid fa-circle-dot"></i><?php else: ?><?php echo e($i + 1); ?><?php endif; ?>
                        </div>
                        <div><p class="text-[10px] font-black <?php echo e($stage === $i ? 'text-red-700' : 'text-gray-600'); ?>"><?php echo e($info['label']); ?></p><p class="text-[10px] text-gray-500"><?php echo e($info['requester_msg']); ?></p></div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role === 'admin'): ?>
        <div id="panel-tracking">
        
        <?php if(!isset($empty)): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Private Tracking Links</p>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-2xl">
                    <i class="fa-solid fa-user-nurse text-blue-500 w-4 flex-shrink-0"></i>
                    <span class="text-xs font-black text-blue-700 w-20 flex-shrink-0">Donor</span>
                    <a href="<?php echo e($donor_link); ?>" target="_blank" class="text-xs text-blue-600 underline truncate flex-1"><?php echo e($donor_link); ?></a>
                    <button onclick="navigator.clipboard.writeText('<?php echo e($donor_link); ?>')" class="flex-shrink-0 text-[10px] px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl font-bold transition">Copy</button>
                </div>
                <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-2xl">
                    <i class="fa-solid fa-person-half-dress text-red-500 w-4 flex-shrink-0"></i>
                    <span class="text-xs font-black text-red-700 w-20 flex-shrink-0">Requester</span>
                    <a href="<?php echo e($requester_link); ?>" target="_blank" class="text-xs text-red-600 underline truncate flex-1"><?php echo e($requester_link); ?></a>
                    <button onclick="navigator.clipboard.writeText('<?php echo e($requester_link); ?>')" class="flex-shrink-0 text-[10px] px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-bold transition">Copy</button>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-amber-50 border border-amber-200 rounded-[2.5rem] p-6 text-center">
            <i class="fa-solid fa-inbox text-amber-400 text-2xl mb-2"></i>
            <p class="text-sm font-bold text-amber-700">No active donation requests yet.</p>
            <p class="text-xs text-amber-600 mt-1">Tracking links will appear here once a blood request is submitted.</p>
        </div>
        <?php endif; ?>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Notification Log</p>
                <span class="text-[10px] text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Auto-refreshes every 10s</span>
            </div>
            <?php if(count($notifications) > 0): ?>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-start gap-3 p-3 rounded-2xl <?php echo e(in_array($notif->status, ['sent','delivered']) ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200'); ?>">
                    <div class="mt-0.5 flex-shrink-0">
                        <?php if($notif->channel === 'email'): ?><i class="fa-solid fa-envelope text-blue-500 text-sm"></i>
                        <?php else: ?><i class="fa-solid fa-bell text-amber-500 text-sm"></i><?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[10px] font-black uppercase tracking-wide text-gray-600"><?php echo e($notif->channel); ?></span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold <?php echo e(in_array($notif->status,['sent','delivered']) ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'); ?>"><?php echo e($notif->status); ?></span>
                            <span class="text-[10px] text-gray-400 ml-auto">Stage <?php echo e($notif->stage); ?> · <?php echo e(\Carbon\Carbon::parse($notif->created_at)->format('H:i:s')); ?></span>
                        </div>
                        <p class="text-xs text-gray-600 mt-0.5 truncate"><?php echo e($notif->message); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <p class="text-sm text-gray-400 text-center py-6">No notifications yet. Update a stage to trigger them.</p>
            <?php endif; ?>
        </div>

        <?php if(!isset($empty)): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-dashed border-gray-300 p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 text-center mb-5">Hospital Control Panel</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="<?php echo e(route('update.stage', 0)); ?>" class="px-5 py-2.5 bg-white border border-gray-300 rounded-2xl text-xs font-bold hover:bg-gray-50 transition"><i class="fa-solid fa-rotate-left mr-1 text-gray-400"></i>Reset</a>
                <a href="<?php echo e(route('update.stage', 1)); ?>" class="px-5 py-2.5 bg-blue-50 border border-blue-300 rounded-2xl text-xs font-bold text-blue-700 hover:bg-blue-100 transition"><i class="fa-solid fa-check mr-1"></i>Accept</a>
                <a href="<?php echo e(route('update.stage', 2)); ?>" class="px-5 py-2.5 bg-purple-50 border border-purple-300 rounded-2xl text-xs font-bold text-purple-700 hover:bg-purple-100 transition"><i class="fa-solid fa-hospital-user mr-1"></i>Arrived</a>
                <a href="<?php echo e(route('update.stage', 3)); ?>" class="px-5 py-2.5 bg-amber-50 border border-amber-300 rounded-2xl text-xs font-bold text-amber-700 hover:bg-amber-100 transition"><i class="fa-solid fa-vial-circle-check mr-1"></i>Matched</a>
                <a href="<?php echo e(route('update.stage', 4)); ?>" class="px-5 py-2.5 bg-red-600 text-white rounded-2xl text-xs font-black shadow-lg shadow-red-200 hover:bg-red-700 transition"><i class="fa-solid fa-heart mr-1"></i>Complete</a>
            </div>
        </div>
        <?php endif; ?>
        </div>

        <?php endif; ?>

    </div>

</body>
</html>
<?php  ?>
