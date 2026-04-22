<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Admin Dashboard</title>
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
    <div class="blood-particle" style="width:20px;height:20px;left:8%;animation-duration:22s;"></div>
    <div class="blood-particle" style="width:40px;height:40px;left:80%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-5xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <span class="hidden sm:flex text-xs text-gray-400 font-mono bg-white/70 px-3 py-1.5 rounded-2xl border border-white items-center">
                <i class="fa-solid fa-shield-halved mr-1 text-red-500"></i>Admin
            </span>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-4 space-y-6">

        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Admin Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Manage users, verify NIDs, and oversee donations.</p>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 text-center">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-user-nurse text-blue-600"></i>
                </div>
                <p class="text-2xl font-extrabold text-gray-800"><?php echo e($totalDonors); ?></p>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mt-1">Donors</p>
            </div>
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 text-center">
                <div class="w-10 h-10 rounded-2xl bg-red-100 flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-person-half-dress text-red-600"></i>
                </div>
                <p class="text-2xl font-extrabold text-gray-800"><?php echo e($totalRequesters); ?></p>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mt-1">Requesters</p>
            </div>
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border <?php echo e($pendingNid > 0 ? 'border-amber-200 bg-amber-50/80' : 'border-white bg-white/80'); ?> backdrop-blur-md shadow-xl p-5 text-center">
                <div class="w-10 h-10 rounded-2xl <?php echo e($pendingNid > 0 ? 'bg-amber-100' : 'bg-gray-100'); ?> flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-id-card <?php echo e($pendingNid > 0 ? 'text-amber-600' : 'text-gray-500'); ?>"></i>
                </div>
                <p class="text-2xl font-extrabold <?php echo e($pendingNid > 0 ? 'text-amber-700' : 'text-gray-800'); ?>"><?php echo e($pendingNid); ?></p>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mt-1">Pending NIDs</p>
            </div>
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 text-center">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-2">
                    <i class="fa-solid fa-users text-emerald-600"></i>
                </div>
                <p class="text-2xl font-extrabold text-gray-800"><?php echo e($totalDonors + $totalRequesters); ?></p>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mt-1">Total Users</p>
            </div>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="<?php echo e(route('admin.users')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-users text-blue-600 text-lg"></i>
                </div>
                <span class="text-sm font-black text-gray-700">All Users</span>
            </a>
            <a href="<?php echo e(route('admin.nid')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border <?php echo e($pendingNid > 0 ? 'border-amber-200' : 'border-white'); ?> shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group relative">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 group-hover:bg-amber-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-id-card text-amber-600 text-lg"></i>
                </div>
                <span class="text-sm font-black text-gray-700">NID Queue</span>
                <?php if($pendingNid > 0): ?>
                <span class="absolute top-3 right-3 bg-red-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full"><?php echo e($pendingNid); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.track')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-droplet text-emerald-600 text-lg"></i>
                </div>
                <span class="text-sm font-black text-gray-700">Donation Track</span>
            </a>
            <a href="<?php echo e(route('dashboard')); ?>"
               class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-white shadow-xl p-5 flex flex-col items-center gap-3 hover:shadow-2xl hover:-translate-y-0.5 transition group">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 group-hover:bg-purple-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-hospital text-purple-600 text-lg"></i>
                </div>
                <span class="text-sm font-black text-gray-700">Hospital Panel</span>
            </a>
        </div>

        
        <?php if(count($recentUsers) > 0): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Recent Registrations</p>
                <a href="<?php echo e(route('admin.users')); ?>" class="text-xs font-bold text-red-600 hover:text-red-700 transition">View all →</a>
            </div>
            <div class="space-y-2">
                <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl">
                    <div class="w-8 h-8 rounded-xl <?php echo e($user->isDonor() ? 'bg-blue-100' : 'bg-red-100'); ?> flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid <?php echo e($user->isDonor() ? 'fa-user-nurse text-blue-600' : 'fa-person-half-dress text-red-600'); ?> text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-gray-800 truncate"><?php echo e($user->name); ?></p>
                        <p class="text-xs text-gray-400 truncate"><?php echo e($user->email); ?></p>
                    </div>
                    <span class="text-[10px] font-black uppercase px-2 py-1 rounded-full <?php echo e($user->isDonor() ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'); ?>"><?php echo e($user->role); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>