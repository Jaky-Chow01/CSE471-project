<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Admin NID Verification</title>
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
    <div class="blood-particle" style="width:35px;height:35px;left:80%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-6 py-4 flex items-center justify-between max-w-7xl mx-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-sm font-bold text-gray-500 hover:text-red-600 transition">Home</a>
            <span class="text-xs text-gray-400 font-mono bg-white/70 px-3 py-1.5 rounded-2xl border border-white">Operator: Admin</span>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 mt-4">
        <a href="{{ route('home') }}" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>

        <div class="mb-6">
            <h2 class="text-2xl font-black text-gray-800">NID Verification Portal</h2>
            <p class="text-gray-500 text-sm mt-1">Upload a donor's National ID card for verification and automatic email notification.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Upload --}}
            <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] shadow-xl border border-white">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-5">Step 1: Upload NID Front</p>
                <div class="aspect-video bg-gray-100 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden cursor-pointer hover:border-red-400 transition" onclick="document.getElementById('file-input').click()">
                    <img id="nid-preview" src="https://placehold.co/600x340/fdf2f2/dc2626?text=Click+to+Upload+NID" class="w-full h-full object-cover rounded-2xl">
                </div>
                <input type="file" id="file-input" class="hidden" accept="image/*" onchange="processFile(event)">
                <button onclick="document.getElementById('file-input').click()" class="mt-5 w-full bg-gray-800 hover:bg-gray-900 text-white py-3 rounded-2xl font-black text-sm transition active:scale-95">
                    <i class="fa-solid fa-camera mr-2"></i>Select NID Image
                </button>
            </div>

            {{-- Verify --}}
            <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] shadow-xl border border-white">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-5">Step 2: AI Verification</p>

                <div id="scan-zone" class="hidden mb-5">
                    <p class="text-[10px] font-black text-blue-600 mb-2 uppercase tracking-wide">Scanning NID Text via API...</p>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="scan-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl">
                        <span class="text-sm text-gray-500 font-bold">Name on ID</span>
                        <span class="font-black text-gray-800">{{ $donor['name'] }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl">
                        <span class="text-sm text-gray-500 font-bold">NID Number</span>
                        <span id="nidVal" class="font-mono font-black text-gray-800">{{ $donor['nid'] }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-red-50 border border-red-100 rounded-2xl">
                        <span class="text-sm text-red-600 font-bold">System Status</span>
                        <span id="apiStatus" class="text-xs font-black text-red-600 uppercase tracking-wide">Idle</span>
                    </div>
                </div>

                <button id="verifyBtn" disabled onclick="verifyAndEmail()"
                        class="w-full bg-gray-200 text-gray-400 font-black py-4 rounded-2xl cursor-not-allowed transition-all text-sm">
                    Verify &amp; Send Welcome Email
                </button>

                <div id="successPanel" class="hidden mt-5 p-4 bg-emerald-500 rounded-2xl text-white text-center font-black text-sm animate-bounce">
                    <i class="fa-solid fa-check-circle mr-2"></i>VERIFIED &amp; EMAIL SENT
                </div>
            </div>
        </div>
    </div>

    <script>
        async function processFile(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => document.getElementById('nid-preview').src = e.target.result;
            reader.readAsDataURL(file);
            const formData = new FormData();
            formData.append('nid_image', file);
            formData.append('_token', '{{ csrf_token() }}');
            const response = await fetch('{{ route("upload.nid") }}', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.status === 'SUCCESS') runScanAnimation();
        }

        function runScanAnimation() {
            const zone = document.getElementById('scan-zone');
            const bar  = document.getElementById('scan-bar');
            const btn  = document.getElementById('verifyBtn');
            const status = document.getElementById('apiStatus');
            zone.classList.remove('hidden');
            status.innerText = 'Scanning...';
            let progress = 0;
            const interval = setInterval(() => {
                progress += 10;
                bar.style.width = progress + '%';
                if (progress >= 100) {
                    clearInterval(interval);
                    status.innerText = 'Ready to Verify';
                    btn.disabled = false;
                    btn.className = 'w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-red-200 cursor-pointer transition-all text-sm active:scale-95';
                }
            }, 150);
        }

        async function verifyAndEmail() {
            const btn = document.getElementById('verifyBtn');
            const success = document.getElementById('successPanel');
            const status  = document.getElementById('apiStatus');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Processing Email...';
            btn.disabled = true;
            const response = await fetch('{{ route("verify.nid") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ nid_number: '{{ $donor["nid"] }}', email: '{{ $donor["email"] }}', name: '{{ $donor["name"] }}' })
            });
            const result = await response.json();
            if (result.status === 'SUCCESS') {
                status.innerText = 'Completed';
                btn.classList.add('hidden');
                success.classList.remove('hidden');
                if (result.message) alert(result.message);
            } else {
                alert(result.message ?? 'Verification failed.');
                btn.innerHTML = 'Verify & Send Welcome Email';
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
