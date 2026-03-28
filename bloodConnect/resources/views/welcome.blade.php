<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fdf2f2;
            /* Subtle medical/cellular texture */
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm66-3c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm-40-39c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm13-11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E");
            overflow-x: hidden;
        }

        /* Animated floating particles */
        .blood-particle {
            position: fixed;
            background: #dc2626;
            border-radius: 50%;
            filter: blur(3px);
            opacity: 0.1;
            z-index: -1;
            bottom: -100px;
            animation: float 25s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg) scale(1); }
            50% { transform: translateY(-500px) rotate(180deg) scale(1.2); }
            100% { transform: translateY(-1200px) rotate(360deg) scale(1); }
        }
    </style>
</head>
<body class="min-h-screen pb-24 relative">

    <div class="blood-particle" style="width: 25px; height: 25px; left: 5%; animation-duration: 18s;"></div>
    <div class="blood-particle" style="width: 45px; height: 40px; left: 20%; animation-duration: 28s; border-radius: 45%;"></div>
    <div class="blood-particle" style="width: 15px; height: 15px; left: 55%; animation-duration: 22s;"></div>
    <div class="blood-particle" style="width: 35px; height: 35px; left: 80%; animation-duration: 20s; border-radius: 35%;"></div>
    <div class="blood-particle" style="width: 55px; height: 50px; left: 45%; animation-duration: 35s; border-radius: 50%;"></div>

    <nav class="p-6 flex items-center justify-between max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
            <span class="text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </div>
    </nav>

    <div class="flex flex-col items-center justify-center mt-10 px-4">
        <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-sm py-10 px-12 text-center max-w-3xl border border-white">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 leading-relaxed">
                Connect with blood donors instantly, <br class="hidden md:block"> 
                Save lives with a simple request.
            </h1>
        </div>

        <div class="mt-12 drop-shadow-2xl">
            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
        </div>

        <a href="{{ route('blood.request.create') }}" 
           class="mt-8 bg-red-600 text-white font-bold py-4 px-12 rounded-2xl hover:bg-red-700 transition-all duration-300 shadow-xl shadow-red-200 active:scale-95 text-lg">
            Find blood now
        </a>
    </div>

    <div class="max-w-2xl mx-auto mt-20 px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Live Announcements</h2>
            <div class="h-1 flex-grow mx-4 bg-gray-200/50 rounded-full"></div>
        </div>

        <div class="space-y-4">
            @forelse($announcements as $request)
                <div class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border-l-8 {{ $request->urgent == 'Urgent' ? 'border-red-600' : 'border-gray-300' }}">
                    <div class="flex justify-between items-start">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-extrabold text-gray-900">{{ $request->bloodgroup }} Needed</span>
                                @if($request->urgent == 'Urgent')
                                    <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-0.5 rounded-full uppercase animate-pulse">Urgent</span>
                                @endif
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">{{ $request->location }}</p>
                            <p class="text-xs text-gray-400">Request for {{ $request->patienttype }} patient (Age: {{ $request->patientage }})</p>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800 mb-1">{{ $request->contactno }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                {{ $request->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white/50 backdrop-blur-sm rounded-[2rem] border-2 border-dashed border-gray-300">
                    <p class="text-gray-400 font-medium">No active blood requests found.</p>
                </div>
            @endforelse
        </div>
    </div>

    <footer class="fixed bottom-0 left-0 right-0 bg-red-600 py-4 shadow-[0_-4px_20px_rgba(220,38,38,0.2)]">
        <p class="text-white text-center font-bold text-sm tracking-wide">
            Every drop counts. Your request could save a life.
        </p>
    </footer>

</body>
</html>