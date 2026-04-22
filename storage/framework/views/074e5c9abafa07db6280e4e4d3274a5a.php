<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Request Submitted</title>
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

    <nav class="px-6 py-4 flex items-center justify-between max-w-4xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="max-w-xl mx-auto px-4 mt-8 space-y-5">

        
        <div class="bg-emerald-50 border border-emerald-200 rounded-[2.5rem] p-8 text-center">
            <div class="w-16 h-16 rounded-3xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-circle-check text-emerald-600 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-800">Request Submitted!</h1>
            <p class="text-sm text-gray-500 mt-2">Your blood request is now active. Use the link below to track its status in real time.</p>
        </div>

        
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-6 space-y-4">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Your Personal Tracking Link</p>

            <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-2xl">
                <i class="fa-solid fa-link text-red-500 w-4 flex-shrink-0"></i>
                <span class="text-xs text-red-600 truncate flex-1" id="tracking-url"><?php echo e($requesterLink); ?></span>
                <button onclick="copyLink()" id="copy-btn"
                        class="flex-shrink-0 text-[10px] px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl font-bold transition">
                    Copy
                </button>
            </div>

            <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 flex-shrink-0"></i>
                <p class="text-xs text-amber-700 font-bold leading-relaxed">
                    Save this link — it is your only way to track your request. You can also use your token
                    <span class="font-mono bg-amber-100 px-1 rounded"><?php echo e($requesterToken); ?></span>
                    on the Track Donation page.
                </p>
            </div>

            <a href="<?php echo e($requesterLink); ?>"
               class="block w-full text-center bg-red-600 hover:bg-red-700 text-white py-3 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                <i class="fa-solid fa-arrow-right mr-2"></i>Go to Tracking Page
            </a>
        </div>

        <a href="<?php echo e(route('home')); ?>"
           class="flex items-center justify-center text-gray-500 hover:text-red-600 font-bold text-sm transition group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Return to Home
        </a>

    </div>

    <script>
        function copyLink() {
            navigator.clipboard.writeText(document.getElementById('tracking-url').innerText).then(() => {
                const btn = document.getElementById('copy-btn');
                btn.innerText = 'Copied!';
                btn.classList.add('bg-emerald-100', 'text-emerald-700');
                btn.classList.remove('bg-red-100', 'text-red-700');
                setTimeout(() => {
                    btn.innerText = 'Copy';
                    btn.classList.remove('bg-emerald-100', 'text-emerald-700');
                    btn.classList.add('bg-red-100', 'text-red-700');
                }, 2000);
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/request-submitted.blade.php ENDPATH**/ ?>