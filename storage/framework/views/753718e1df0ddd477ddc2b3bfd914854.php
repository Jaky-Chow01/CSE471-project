<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
        .role-card input[type="radio"]:checked + label { border-color: #dc2626; background: #fef2f2; }
        .role-card input[type="radio"]:checked + label .role-icon { background: #fecaca; color: #dc2626; }
    </style>
</head>
<body class="min-h-screen flex flex-col relative">
    <div class="blood-particle" style="width:20px;height:20px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:35px;height:35px;left:75%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-6 py-4 flex items-center justify-between max-w-4xl mx-auto w-full">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">

            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-3xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-plus text-red-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800">Create your account</h1>
                <p class="text-sm text-gray-500 mt-1">Join bloodConnect and help save lives</p>
            </div>

            <?php if($errors->any()): ?>
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>

            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-8">
                <form method="POST" action="<?php echo e(route('register.post')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-3">I am joining as</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="role-card">
                                <input type="radio" name="role" id="role-donor" value="donor" class="sr-only"
                                       <?php echo e(old('role') === 'donor' ? 'checked' : ''); ?>>
                                <label for="role-donor" class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-gray-50 cursor-pointer transition hover:border-red-300">
                                    <div class="role-icon w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center transition">
                                        <i class="fa-solid fa-user-nurse"></i>
                                    </div>
                                    <span class="text-sm font-black text-gray-700">I am a Donor</span>
                                    <span class="text-[10px] text-gray-400 text-center leading-relaxed">I want to donate blood</span>
                                </label>
                            </div>
                            <div class="role-card">
                                <input type="radio" name="role" id="role-requester" value="requester" class="sr-only"
                                       <?php echo e(old('role', 'requester') === 'requester' ? 'checked' : ''); ?>>
                                <label for="role-requester" class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-gray-50 cursor-pointer transition hover:border-red-300">
                                    <div class="role-icon w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center transition">
                                        <i class="fa-solid fa-person-half-dress"></i>
                                    </div>
                                    <span class="text-sm font-black text-gray-700">I Need Blood</span>
                                    <span class="text-[10px] text-gray-400 text-center leading-relaxed">I want to request blood</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Full Name</label>
                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="Your full name">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Email Address</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="At least 8 characters">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="Repeat your password">
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                        <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="<?php echo e(route('login')); ?>" class="font-black text-red-600 hover:text-red-700 transition">Sign in here</a>
            </p>

        </div>
    </div>
</body>
</html>
<?php  ?>
