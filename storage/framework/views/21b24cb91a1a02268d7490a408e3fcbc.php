<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Submit NID</title>
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

    <?php $isDonor = auth()->user()->isDonor(); ?>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-4xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="<?php echo e($isDonor ? route('donor.dashboard') : route('requester.dashboard')); ?>" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">My Panel</a>
            <a href="<?php echo e(route('logout')); ?>" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-xl mx-auto px-4 mt-4 space-y-5">

        <div class="flex items-center gap-3">
            <a href="<?php echo e($isDonor ? route('donor.dashboard') : route('requester.dashboard')); ?>"
               class="flex items-center text-gray-500 font-bold text-sm hover:text-red-600 transition group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Panel
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800">NID Verification</h1>
                <p class="text-sm text-gray-500">Submit your National ID card for identity verification.</p>
            </div>
        </div>

        <?php if(session('success')): ?>
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold">
            <i class="fa-solid fa-circle-exclamation mr-1"></i> <?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        
        <?php if($existing && $existing->status === 'verified'): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-emerald-200 shadow-xl p-8 text-center">
            <div class="w-16 h-16 rounded-3xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-shield-check text-emerald-600 text-3xl"></i>
            </div>
            <h2 class="text-xl font-extrabold text-emerald-700">NID Verified</h2>
            <p class="text-sm text-gray-500 mt-2">Your identity has been verified. No further action needed.</p>
            <p class="text-xs text-gray-400 mt-1">Verified on <?php echo e($existing->verified_at?->format('d M Y') ?? 'N/A'); ?></p>
        </div>

        <?php elseif($existing && $existing->status === 'pending'): ?>
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-amber-200 shadow-xl p-8 text-center">
            <div class="w-16 h-16 rounded-3xl bg-amber-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-clock text-amber-500 text-3xl"></i>
            </div>
            <h2 class="text-xl font-extrabold text-amber-700">Under Review</h2>
            <p class="text-sm text-gray-500 mt-2">Your NID submission is being reviewed by our admin team.</p>
            <p class="text-xs text-gray-400 mt-1">Submitted on <?php echo e($existing->created_at->format('d M Y')); ?></p>
            <div class="mt-4 p-3 bg-gray-50 rounded-2xl text-left space-y-1">
                <p class="text-xs font-bold text-gray-600">Name: <?php echo e($existing->full_name); ?></p>
                <p class="text-xs font-bold text-gray-600">NID: <?php echo e($existing->nid_number); ?></p>
            </div>
        </div>

        <?php else: ?>
        
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-8">
            <?php if($existing && $existing->status === 'rejected'): ?>
            <div class="p-3 bg-red-50 border border-red-200 rounded-2xl mb-5 text-sm text-red-700 font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i> Previous submission rejected. Please re-submit with a clear NID image.
            </div>
            <?php endif; ?>

            <form method="POST"
                  action="<?php echo e($isDonor ? route('donor.nid.store') : route('requester.nid.store')); ?>"
                  enctype="multipart/form-data"
                  class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Full Name (as on NID)</label>
                    <input type="text" name="full_name" value="<?php echo e(old('full_name', $existing->full_name ?? '')); ?>" required
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                           placeholder="Your full name as printed on NID">
                </div>

                <div>
                    <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">NID Number</label>
                    <input type="text" name="nid_number" value="<?php echo e(old('nid_number', $existing->nid_number ?? '')); ?>" required
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition font-mono"
                           placeholder="e.g. 1990123456789">
                </div>

                <div>
                    <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">NID Front Image</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-red-400 transition cursor-pointer" onclick="document.getElementById('nid-img').click()">
                        <img id="img-preview" src="" alt="" class="hidden w-full max-h-48 object-cover rounded-xl mb-3 mx-auto">
                        <div id="img-placeholder">
                            <i class="fa-solid fa-cloud-arrow-up text-gray-300 text-3xl mb-2"></i>
                            <p class="text-sm font-bold text-gray-400">Click to upload NID front image</p>
                            <p class="text-xs text-gray-300 mt-1">JPG, PNG — max 4MB</p>
                        </div>
                    </div>
                    <input type="file" id="nid-img" name="nid_image" accept="image/*" class="hidden" onchange="previewImage(event)" required>
                </div>

                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Submit for Verification
                </button>
            </form>
        </div>
        <?php endif; ?>

    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('img-preview');
                const placeholder = document.getElementById('img-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/nid/submit.blade.php ENDPATH**/ ?>