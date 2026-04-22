<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
    </style>
</head>
<body class="min-h-screen pb-20 relative">

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-5xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">Dashboard</a>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-4 space-y-5">

        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center text-gray-500 font-bold text-sm hover:text-red-600 transition group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
            <h1 class="text-2xl font-extrabold text-gray-800">All Users</h1>
        </div>

        <?php if(session('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Registered Members</p>
            </div>
            <?php if($users->count() > 0): ?>
            <div class="divide-y divide-gray-100">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $nid = $user->nidVerification; ?>
                <div class="flex items-center gap-3 px-4 sm:px-6 py-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 rounded-2xl <?php echo e($user->isDonor() ? 'bg-blue-100' : 'bg-red-100'); ?> flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid <?php echo e($user->isDonor() ? 'fa-user-nurse text-blue-600' : 'fa-person-half-dress text-red-600'); ?> text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-gray-800 truncate"><?php echo e($user->name); ?></p>
                        <p class="text-xs text-gray-400 truncate"><?php echo e($user->email); ?></p>
                    </div>
                    <span class="hidden sm:inline text-[10px] font-black uppercase px-2.5 py-1 rounded-full <?php echo e($user->isDonor() ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'); ?>">
                        <?php echo e($user->role); ?>

                    </span>
                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full
                        <?php if(!$nid): ?> bg-gray-100 text-gray-500
                        <?php elseif($nid->status === 'verified'): ?> bg-emerald-100 text-emerald-700
                        <?php elseif($nid->status === 'pending'): ?> bg-amber-100 text-amber-700
                        <?php else: ?> bg-red-100 text-red-700 <?php endif; ?>">
                        <?php if(!$nid): ?> No NID <?php else: ?> <?php echo e($nid->status); ?> <?php endif; ?>
                    </span>
                    <span class="hidden sm:inline text-[10px] text-gray-400 flex-shrink-0"><?php echo e($user->created_at->format('d M Y')); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="p-4 border-t border-gray-100">
                <?php echo e($users->links()); ?>

            </div>
            <?php else: ?>
            <div class="p-12 text-center">
                <i class="fa-solid fa-users text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-400 font-bold">No users registered yet.</p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/admin/users.blade.php ENDPATH**/ ?>