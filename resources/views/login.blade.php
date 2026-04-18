<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Connect - Track Donation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col">

<nav class="bg-white border-b p-4 shadow-sm">
    <div class="max-w-4xl mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-red-600">
            <i class="fa-solid fa-droplet mr-1"></i> Blood Connect
        </a>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-500 hover:text-red-600">Home</a>
    </div>
</nav>

<div class="flex-1 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-4xl">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-800">Track Your Donation</h1>
            <p class="text-gray-500 mt-2">Select your role to access your personalized tracking page</p>
        </div>

        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 max-w-md mx-auto">
            <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Donor Card -->
            <div class="bg-white rounded-2xl shadow border border-blue-100 p-7 flex flex-col">
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-user-nurse text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-1">I am a Donor</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1">
                    Enter the tracking token from your email to view your donation status.
                </p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="donor">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">
                        Your Token
                    </label>
                    <input
                        type="text"
                        name="token"
                        placeholder="Paste token from email"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4 font-mono"
                    >
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl text-sm transition">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Access Donor View
                    </button>
                </form>
            </div>

            <!-- Requester Card -->
            <div class="bg-white rounded-2xl shadow border border-red-100 p-7 flex flex-col">
                <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-person-half-dress text-red-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-1">I Need Blood</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1">
                    Enter the tracking token from your confirmation email to follow your request.
                </p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="requester">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">
                        Your Token
                    </label>
                    <input
                        type="text"
                        name="token"
                        placeholder="Paste token from email"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-300 mb-4 font-mono"
                    >
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl text-sm transition">
                        <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Access Requester View
                    </button>
                </form>
            </div>

            <!-- Admin Card -->
            <div class="bg-white rounded-2xl shadow border border-slate-200 p-7 flex flex-col">
                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-5">
                    <i class="fa-solid fa-hospital text-slate-600 text-2xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-1">Hospital Staff</h2>
                <p class="text-sm text-gray-500 mb-6 flex-1">
                    Admin access to manage donation stages and view all tracking details.
                </p>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wide">
                        Admin Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter admin password"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-slate-300 mb-4"
                    >
                    <button type="submit"
                        class="w-full bg-slate-700 hover:bg-slate-800 text-white font-bold py-3 rounded-xl text-sm transition">
                        <i class="fa-solid fa-shield-halved mr-2"></i>Access Admin Panel
                    </button>
                </form>
            </div>

        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            Tokens are sent via email at each stage update. Contact the hospital if you have not received yours.
        </p>

    </div>
</div>

</body>
</html>
