<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Connect - Live Tracking</title>
    <meta http-equiv="refresh" content="10">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans">

<nav class="bg-white border-b p-4 mb-10 shadow-sm">
    <div class="max-w-3xl mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold text-red-600"><i class="fa-solid fa-truck-fast"></i> Live Tracker</h1>
        <div class="flex gap-4 items-center">
            @if($role === 'admin')
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-red-600">Home</a>
            <a href="{{ route('admin') }}" class="text-sm font-bold text-gray-500 hover:text-red-600">Admin</a>
            <a href="{{ route('logout') }}" class="text-sm font-bold text-red-500 hover:text-red-700">
                <i class="fa-solid fa-right-from-bracket mr-1"></i>Logout
            </a>
            @else
            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-red-600">
                <i class="fa-solid fa-right-from-bracket mr-1"></i>Exit
            </a>
            @endif
        </div>
    </div>
</nav>

<div class="max-w-3xl mx-auto px-4 space-y-6">

    {{-- Role Badge --}}
    @if($role === 'donor')
    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-2xl px-6 py-3">
        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
            <i class="fa-solid fa-user-nurse text-blue-600"></i>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-400">Donor Portal</p>
            <p class="text-sm font-semibold text-gray-700">You are viewing your donor tracking page</p>
        </div>
    </div>
    @elseif($role === 'requester')
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-2xl px-6 py-3">
        <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center">
            <i class="fa-solid fa-person-half-dress text-red-600"></i>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-red-400">Requester Portal</p>
            <p class="text-sm font-semibold text-gray-700">You are viewing your requester tracking page</p>
        </div>
    </div>
    @else
    <div class="flex items-center gap-3 bg-slate-100 border border-slate-200 rounded-2xl px-6 py-3">
        <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center">
            <i class="fa-solid fa-shield-halved text-slate-600"></i>
        </div>
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Admin View</p>
            <p class="text-sm font-semibold text-gray-700">Showing both donor and requester perspectives</p>
        </div>
    </div>
    @endif

    {{-- Current Stage Banner --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 text-center">
        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Current Stage</p>
        <h2 class="text-3xl font-black text-red-600">
            {{ $stages[$stage]['label'] }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Step {{ $stage + 1 }} of 5 &nbsp;·&nbsp; Live synchronization active</p>
    </div>

    {{-- Progress Bar --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-8">
        <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 text-center mb-8">Donation Progress</h3>
        <div class="relative flex items-center justify-between">
            <div class="absolute left-0 top-5 w-full h-1 bg-gray-200"></div>
            <div class="absolute left-0 top-5 h-1 bg-green-500 transition-all duration-700"
                 style="width: {{ $stage * 25 }}%"></div>
            @for($i = 0; $i < 5; $i++)
            @php $info = $stages[$i]; @endphp
            <div class="relative z-10 flex flex-col items-center w-1/5">
                <div class="w-10 h-10 rounded-full flex items-center justify-center border-4
                    {{ $stage >= $i ? 'bg-green-500 border-green-500 text-white shadow-lg' : 'bg-white border-gray-200 text-gray-300' }}">
                    <i class="fa-solid {{ $info['icon'] }} text-xs"></i>
                </div>
                <span class="mt-3 text-[10px] font-bold uppercase text-center
                    {{ $stage >= $i ? 'text-green-600' : 'text-gray-400' }}">
                    {{ $info['label'] }}
                </span>
            </div>
            @endfor
        </div>
    </div>

    {{-- Role-Specific Stage Detail --}}
    @if($role === 'donor')
    <div class="bg-white rounded-2xl shadow border border-blue-100 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fa-solid fa-user-nurse text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-blue-400">Your Progress</p>
                <p class="text-sm font-semibold text-gray-700">What's happening on your end</p>
            </div>
        </div>
        <div class="space-y-3">
            @for($i = 0; $i < 5; $i++)
            @php $info = $stages[$i]; @endphp
            <div class="flex items-start gap-3 p-3 rounded-xl
                {{ $stage === $i ? 'bg-blue-50 border border-blue-200' : ($stage < $i ? 'opacity-40' : '') }}">
                <div class="mt-0.5 w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center
                    {{ $stage >= $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                    @if($stage > $i)
                        <i class="fa-solid fa-check text-[10px]"></i>
                    @elseif($stage === $i)
                        <i class="fa-solid fa-circle-dot text-[10px]"></i>
                    @else
                        <span class="text-[10px] font-bold">{{ $i + 1 }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold {{ $stage === $i ? 'text-blue-700' : 'text-gray-600' }}">
                        {{ $info['label'] }}
                    </p>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $info['donor_msg'] }}</p>
                </div>
            </div>
            @endfor
        </div>
    </div>

    @elseif($role === 'requester')
    <div class="bg-white rounded-2xl shadow border border-red-100 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fa-solid fa-person-half-dress text-red-600"></i>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-red-400">Your Progress</p>
                <p class="text-sm font-semibold text-gray-700">What's happening with your request</p>
            </div>
        </div>
        <div class="space-y-3">
            @for($i = 0; $i < 5; $i++)
            @php $info = $stages[$i]; @endphp
            <div class="flex items-start gap-3 p-3 rounded-xl
                {{ $stage === $i ? 'bg-red-50 border border-red-200' : ($stage < $i ? 'opacity-40' : '') }}">
                <div class="mt-0.5 w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center
                    {{ $stage >= $i ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                    @if($stage > $i)
                        <i class="fa-solid fa-check text-[10px]"></i>
                    @elseif($stage === $i)
                        <i class="fa-solid fa-circle-dot text-[10px]"></i>
                    @else
                        <span class="text-[10px] font-bold">{{ $i + 1 }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold {{ $stage === $i ? 'text-red-700' : 'text-gray-600' }}">
                        {{ $info['label'] }}
                    </p>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $info['requester_msg'] }}</p>
                </div>
            </div>
            @endfor
        </div>
    </div>

    @else
    {{-- Admin: both panels side by side --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Donor View -->
        <div class="bg-white rounded-2xl shadow border border-blue-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-user-nurse text-blue-600"></i>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-400">Donor View</p>
                    <p class="text-sm font-semibold text-gray-700">What the donor sees</p>
                </div>
            </div>
            <div class="space-y-3">
                @for($i = 0; $i < 5; $i++)
                @php $info = $stages[$i]; @endphp
                <div class="flex items-start gap-3 p-3 rounded-xl
                    {{ $stage === $i ? 'bg-blue-50 border border-blue-200' : ($stage < $i ? 'opacity-40' : '') }}">
                    <div class="mt-0.5 w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center
                        {{ $stage >= $i ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                        @if($stage > $i)
                            <i class="fa-solid fa-check text-[10px]"></i>
                        @elseif($stage === $i)
                            <i class="fa-solid fa-circle-dot text-[10px]"></i>
                        @else
                            <span class="text-[10px] font-bold">{{ $i + 1 }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold {{ $stage === $i ? 'text-blue-700' : 'text-gray-600' }}">
                            {{ $info['label'] }}
                        </p>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $info['donor_msg'] }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Requester View -->
        <div class="bg-white rounded-2xl shadow border border-red-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fa-solid fa-person-half-dress text-red-600"></i>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-red-400">Requester View</p>
                    <p class="text-sm font-semibold text-gray-700">What the requester sees</p>
                </div>
            </div>
            <div class="space-y-3">
                @for($i = 0; $i < 5; $i++)
                @php $info = $stages[$i]; @endphp
                <div class="flex items-start gap-3 p-3 rounded-xl
                    {{ $stage === $i ? 'bg-red-50 border border-red-200' : ($stage < $i ? 'opacity-40' : '') }}">
                    <div class="mt-0.5 w-6 h-6 rounded-full flex-shrink-0 flex items-center justify-center
                        {{ $stage >= $i ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                        @if($stage > $i)
                            <i class="fa-solid fa-check text-[10px]"></i>
                        @elseif($stage === $i)
                            <i class="fa-solid fa-circle-dot text-[10px]"></i>
                        @else
                            <span class="text-[10px] font-bold">{{ $i + 1 }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-bold {{ $stage === $i ? 'text-red-700' : 'text-gray-600' }}">
                            {{ $info['label'] }}
                        </p>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $info['requester_msg'] }}</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

    </div>
    @endif

    @if($role === 'admin')

    {{-- Share Links --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-5">
            <i class="fa-solid fa-link text-slate-500"></i>
            <h3 class="text-sm font-bold text-gray-700">Private Tracking Links</h3>
            <span class="ml-auto text-xs text-gray-400">Share with the respective party only</span>
        </div>
        <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                <i class="fa-solid fa-user-nurse text-blue-500 w-4"></i>
                <span class="text-xs font-bold text-blue-700 w-16 flex-shrink-0">Donor</span>
                <a href="{{ $donor_link }}" target="_blank"
                   class="text-xs text-blue-600 underline truncate flex-1">{{ $donor_link }}</a>
                <button onclick="navigator.clipboard.writeText('{{ $donor_link }}')"
                        class="flex-shrink-0 text-[10px] px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg font-semibold transition">
                    Copy
                </button>
            </div>
            <div class="flex items-center gap-3 p-3 bg-red-50 border border-red-200 rounded-xl">
                <i class="fa-solid fa-person-half-dress text-red-500 w-4"></i>
                <span class="text-xs font-bold text-red-700 w-16 flex-shrink-0">Requester</span>
                <a href="{{ $requester_link }}" target="_blank"
                   class="text-xs text-red-600 underline truncate flex-1">{{ $requester_link }}</a>
                <button onclick="navigator.clipboard.writeText('{{ $requester_link }}')"
                        class="flex-shrink-0 text-[10px] px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-semibold transition">
                    Copy
                </button>
            </div>
        </div>
    </div>

    {{-- Notification Feed --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-5">
            <i class="fa-solid fa-bell text-amber-500"></i>
            <h3 class="text-sm font-bold text-gray-700">Notification Log</h3>
            <span class="ml-auto text-xs text-gray-400">Auto-refreshes every 10 s</span>
        </div>
        @if(count($notifications) > 0)
        <div class="space-y-2 max-h-64 overflow-y-auto">
            @foreach($notifications as $notif)
            <div class="flex items-start gap-3 p-3 rounded-xl
                {{ in_array($notif->status, ['sent', 'delivered']) ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                <div class="mt-0.5 flex-shrink-0">
                    @if($notif->channel === 'email')
                        <i class="fa-solid fa-envelope text-blue-500 text-sm"></i>
                    @elseif($notif->channel === 'sms')
                        <i class="fa-solid fa-mobile-screen-button text-green-500 text-sm"></i>
                    @else
                        <i class="fa-solid fa-bell text-amber-500 text-sm"></i>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] font-bold uppercase tracking-wide
                            {{ $notif->channel === 'email' ? 'text-blue-600' : ($notif->channel === 'sms' ? 'text-green-600' : 'text-amber-600') }}">
                            {{ $notif->channel }}
                        </span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold
                            {{ in_array($notif->status, ['sent','delivered']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $notif->status }}
                        </span>
                        <span class="text-[10px] text-gray-400 ml-auto">
                            Stage {{ $notif->stage }} · {{ \Carbon\Carbon::parse($notif->created_at)->format('H:i:s') }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 mt-0.5 truncate">{{ $notif->message }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400 text-center py-4">No notifications yet. Update a stage to trigger them.</p>
        @endif
    </div>

    {{-- Hospital Control Panel --}}
    <div class="bg-white rounded-2xl shadow border border-dashed border-slate-300 p-6">
        <h3 class="text-xs font-bold text-slate-500 mb-4 uppercase text-center">Hospital Control Panel</h3>
        <div class="flex flex-wrap justify-center gap-2">
            <a href="{{ route('update.stage', 0) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold hover:bg-gray-50 transition">
                <i class="fa-solid fa-rotate-left mr-1 text-gray-400"></i>Reset
            </a>
            <a href="{{ route('update.stage', 1) }}" class="px-4 py-2 bg-white border border-blue-300 rounded-lg text-xs font-semibold text-blue-700 hover:bg-blue-50 transition">
                <i class="fa-solid fa-check mr-1"></i>Accept
            </a>
            <a href="{{ route('update.stage', 2) }}" class="px-4 py-2 bg-white border border-purple-300 rounded-lg text-xs font-semibold text-purple-700 hover:bg-purple-50 transition">
                <i class="fa-solid fa-hospital-user mr-1"></i>Arrived
            </a>
            <a href="{{ route('update.stage', 3) }}" class="px-4 py-2 bg-white border border-orange-300 rounded-lg text-xs font-semibold text-orange-700 hover:bg-orange-50 transition">
                <i class="fa-solid fa-vial-circle-check mr-1"></i>Matched
            </a>
            <a href="{{ route('update.stage', 4) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-bold shadow-md hover:bg-green-700 transition">
                <i class="fa-solid fa-heart mr-1"></i>Complete
            </a>
        </div>
    </div>

    @endif

</div>

<div class="h-12"></div>
</body>
</html>
