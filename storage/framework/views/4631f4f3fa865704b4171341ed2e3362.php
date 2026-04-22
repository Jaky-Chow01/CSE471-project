<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen flex flex-col relative">
    <div class="blood-particle" style="width:20px;height:20px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:35px;height:35px;left:80%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-6 py-4 flex items-center justify-between max-w-4xl mx-auto w-full">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-3xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-droplet text-red-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800">Welcome back</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to your bloodConnect account</p>
            </div>

            <?php if(session('error')): ?>
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>

            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-8">
                <form method="POST" action="<?php echo e(route('login.post')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Email Address</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="••••••••">
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="rounded accent-red-600">
                        <label for="remember" class="text-sm text-gray-500 font-semibold">Remember me</label>
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>Sign In
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="<?php echo e(route('register')); ?>" class="font-black text-red-600 hover:text-red-700 transition">Register here</a>
            </p>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/auth/login.blade.php ENDPATH**/ ?>