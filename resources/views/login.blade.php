<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Track Donation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.08; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen flex flex-col relative">
    <div class="blood-particle" style="width:25px;height:25px;left:15%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:40px;height:40px;left:70%;animation-duration:30s;border-radius:40%;"></div>

    <nav class="px-6 py-4 flex items-center justify-between max-w-7xl mx-auto w-full">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-red-600 transition">Home</a>
    </nav>

    <div class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-800">Track Your Donation</h1>
            <p class="text-gray-500 mt-2 text-sm">Select your role to access your personalized tracking page.</p>
        </div>

        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-[1.5rem] px-5 py-4 max-w-md w-full">
            <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
            <p class="text-sm font-bold">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 w-full max-w-4xl">

            {{-- Donor --}}
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-7 flex flex-col">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center mb-5 flex-shrink-0">
                    <i class="fa-solid fa-user-nurse text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-black text-gray-800 mb-1">I am a Donor</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1 leading-relaxed">Enter the tracking token from your email to view your donation status.</p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="donor">
                    <label class="block text-[10px] font-black text-gray-400 mb-1.5 uppercase tracking-wide">Your Token</label>
                    <input type="text" name="token" placeholder="Paste token from email" required
                           class="w-full bg-gray-100/80 border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4 font-mono">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-3 rounded-2xl text-sm transition shadow-lg shadow-blue-200 active:scale-95">
                        Track as Donor →
                    </button>
                </form>
            </div>

            {{-- Requester --}}
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-7 flex flex-col">
                <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center mb-5 flex-shrink-0">
                    <i class="fa-solid fa-person-half-dress text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-black text-gray-800 mb-1">I Need Blood</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1 leading-relaxed">Track your active blood request with your requester token.</p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="requester">
                    <label class="block text-[10px] font-black text-gray-400 mb-1.5 uppercase tracking-wide">Your Token</label>
                    <input type="text" name="token" placeholder="Paste token from email" required
                           class="w-full bg-gray-100/80 border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-300 mb-4 font-mono">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-2xl text-sm transition shadow-lg shadow-red-200 active:scale-95">
                        Track as Requester →
                    </button>
                </form>
            </div>

            {{-- Admin --}}
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-7 flex flex-col">
                <div class="w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-5 flex-shrink-0">
                    <i class="fa-solid fa-shield-halved text-gray-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-black text-gray-800 mb-1">Hospital Admin</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1 leading-relaxed">Control the donation pipeline and advance stages in real-time.</p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <label class="block text-[10px] font-black text-gray-400 mb-1.5 uppercase tracking-wide">Admin Password</label>
                    <input type="password" name="password" placeholder="Enter admin password" required
                           class="w-full bg-gray-100/80 border border-gray-200 rounded-2xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 mb-4">
                    <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-black py-3 rounded-2xl text-sm transition active:scale-95">
                        Admin Login →
                    </button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
