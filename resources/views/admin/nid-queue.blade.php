<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | NID Verification Queue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
    </style>
</head>
<body class="min-h-screen pb-20 relative">

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-5xl mx-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-lg sm:text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline text-sm font-bold text-gray-500 hover:text-red-600 transition">Dashboard</a>
            <a href="{{ route('logout') }}" class="text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-2xl transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i><span class="hidden sm:inline">Logout</span>
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-4 space-y-5">

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-500 font-bold text-sm hover:text-red-600 transition group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800">NID Verification Queue</h1>
                <p class="text-sm text-gray-500">Review and verify submitted National ID cards.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($pending->count() > 0)
        <div class="space-y-4">
            @foreach($pending as $nid)
            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-amber-200 shadow-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- User Info --}}
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl {{ $nid->user && $nid->user->isDonor() ? 'bg-blue-100' : 'bg-red-100' }} flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid {{ $nid->user && $nid->user->isDonor() ? 'fa-user-nurse text-blue-600' : 'fa-person-half-dress text-red-600' }} text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-800">{{ $nid->user->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-400">{{ $nid->user->email ?? '—' }}</p>
                            </div>
                            <span class="ml-auto text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-2xl">
                                <span class="text-xs text-gray-500 font-bold">Name on NID</span>
                                <span class="text-sm font-black text-gray-800">{{ $nid->full_name }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-2xl">
                                <span class="text-xs text-gray-500 font-bold">NID Number</span>
                                <span class="font-mono text-sm font-black text-gray-800">{{ $nid->nid_number }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-2xl">
                                <span class="text-xs text-gray-500 font-bold">Submitted</span>
                                <span class="text-xs font-bold text-gray-600">{{ $nid->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('admin.nid.verify', $nid) }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-2xl font-black text-sm transition active:scale-95">
                                    <i class="fa-solid fa-check mr-1"></i>Verify
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.nid.reject', $nid) }}" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-2.5 rounded-2xl font-black text-sm transition active:scale-95">
                                    <i class="fa-solid fa-xmark mr-1"></i>Reject
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- NID Image --}}
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">NID Image</p>
                        @if($nid->image_path)
                        <img src="{{ Storage::url($nid->image_path) }}"
                             alt="NID for {{ $nid->full_name }}"
                             class="w-full rounded-2xl border border-gray-200 object-cover max-h-56">
                        @else
                        <div class="w-full h-40 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-image text-3xl"></i>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] border border-white shadow-xl p-16 text-center">
            <div class="w-16 h-16 rounded-3xl bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check-double text-emerald-600 text-2xl"></i>
            </div>
            <h2 class="text-xl font-extrabold text-gray-700">All caught up!</h2>
            <p class="text-sm text-gray-400 mt-2">No pending NID submissions to review.</p>
        </div>
        @endif

    </div>
</body>
</html>
