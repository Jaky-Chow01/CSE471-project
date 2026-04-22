<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Leaderboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.08; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen pb-24 relative">
    <div class="blood-particle" style="width:25px;height:25px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:40px;height:40px;left:80%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-7xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl sm:text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <a href="<?php echo e(route('home')); ?>" class="text-sm font-bold text-gray-600 hover:text-red-600 transition">← Back</a>
    </nav>

    <div class="max-w-2xl mx-auto px-4 mt-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800">🏆 Global Leaderboard</h1>
            <p class="text-gray-500 mt-2 text-sm">Top donors by lifetime bags donated</p>
        </div>

        <div class="bg-white/80 backdrop-blur-md rounded-[3rem] shadow-xl border border-white overflow-hidden">
            <?php $__empty_1 = true; $__currentLoopData = $topDonors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-4 px-6 py-4 <?php echo e(!$loop->last ? 'border-b border-gray-100' : ''); ?> <?php echo e($index < 3 ? 'bg-gradient-to-r from-red-50/50 to-transparent' : ''); ?> hover:bg-red-50/30 transition">
                <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center font-extrabold text-sm
                    <?php echo e($index == 0 ? 'bg-yellow-400 text-white shadow-lg shadow-yellow-200' :
                       ($index == 1 ? 'bg-gray-400 text-white shadow-lg shadow-gray-200' :
                       ($index == 2 ? 'bg-amber-600 text-white shadow-lg shadow-amber-200' : 'bg-gray-100 text-gray-500'))); ?>">
                    <?php echo e($index == 0 ? '🥇' : ($index == 1 ? '🥈' : ($index == 2 ? '🥉' : $index + 1))); ?>

                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 truncate"><?php echo e($donor->name); ?></p>
                    <p class="text-xs text-gray-400 truncate"><?php echo e($donor->email); ?></p>
                </div>
                <div class="flex-shrink-0 text-right">
                    <p class="font-extrabold text-red-600 text-lg"><?php echo e($donor->total_bags ?? 0); ?></p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">bags</p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-16">
                <div class="text-5xl mb-4">🩸</div>
                <p class="text-gray-400 font-bold">No donations recorded yet.</p>
                <p class="text-gray-400 text-sm mt-1">Be the first to make a difference!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/leaderboard.blade.php ENDPATH**/ ?>