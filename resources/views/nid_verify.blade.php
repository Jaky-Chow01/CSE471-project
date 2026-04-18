<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - NID Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans">

<nav class="bg-white border-b p-4 mb-8 shadow-sm">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-4">
            <h1 class="text-xl font-bold text-red-600"><i class="fa-solid fa-droplet"></i> Blood Connect Admin</h1>
            <a href="{{ route('home') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Map
            </a>
        </div>
        <span class="text-xs text-gray-400 font-mono bg-gray-50 px-3 py-1 rounded-full border">Operator: 21201505</span>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- LEFT: UPLOAD -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Step 1: Upload NID Front</h3>
            <div class="aspect-video bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                <img id="nid-preview" src="https://placehold.co/600x400/e2e8f0/475569?text=Waiting+for+Upload" class="w-full h-full object-cover">
            </div>
            <input type="file" id="file-input" class="hidden" accept="image/*" onchange="processFile(event)">
            <button onclick="document.getElementById('file-input').click()" class="mt-4 w-full bg-slate-800 text-white py-3 rounded-xl font-bold hover:bg-slate-700">
                <i class="fa-solid fa-camera mr-2"></i> Select NID Image
            </button>
        </div>

        <!-- RIGHT: SCAN & VERIFY -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Step 2: AI Verification</h3>

            <!-- Progress Bar -->
            <div id="scan-zone" class="hidden mb-6">
                <p class="text-xs font-bold text-blue-600 mb-2 uppercase">Scanning NID Text via API...</p>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="scan-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between p-4 bg-gray-50 rounded-xl">
                    <span class="text-gray-600">Name on ID</span>
                    <span class="font-bold text-gray-800">{{ $donor['name'] }}</span>
                </div>
                <div class="flex justify-between p-4 bg-gray-50 rounded-xl">
                    <span class="text-gray-600">NID Number</span>
                    <span id="nidVal" class="font-mono font-bold text-gray-800">{{ $donor['nid'] }}</span>
                </div>
                <div class="flex justify-between p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <span class="text-blue-700 font-medium">System Status</span>
                    <span id="apiStatus" class="text-xs font-black text-blue-600 uppercase">Idle</span>
                </div>
            </div>

            <button id="verifyBtn" disabled onclick="verifyAndEmail()" class="mt-8 w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-xl cursor-not-allowed transition-all">
                Verify & Send Welcome Email
            </button>

            <div id="successPanel" class="hidden mt-8 p-4 bg-green-600 rounded-xl text-white text-center font-bold animate-bounce">
                <i class="fa-solid fa-check-circle mr-2"></i> VERIFIED & EMAIL SENT
            </div>
        </div>
    </div>
</div>

<script>
    async function processFile(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Preview
        const reader = new FileReader();
        reader.onload = (e) => document.getElementById('nid-preview').src = e.target.result;
        reader.readAsDataURL(file);

        // Upload to Laravel
        const formData = new FormData();
        formData.append('nid_image', file);
        formData.append('_token', '{{ csrf_token() }}');

        const response = await fetch('{{ route("upload.nid") }}', { method: 'POST', body: formData });
        const data = await response.json();

        if (data.status === "SUCCESS") {
            runScanAnimation();
        }
    }

    function runScanAnimation() {
        const zone = document.getElementById('scan-zone');
        const bar  = document.getElementById('scan-bar');
        const btn  = document.getElementById('verifyBtn');
        const status = document.getElementById('apiStatus');

        zone.classList.remove('hidden');
        status.innerText = "Scanning...";

        let progress = 0;
        let interval = setInterval(() => {
            progress += 10;
            bar.style.width = progress + '%';
            if (progress >= 100) {
                clearInterval(interval);
                status.innerText = "Ready to Verify";
                btn.disabled = false;
                btn.className = "mt-8 w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg cursor-pointer";
            }
        }, 150);
    }

    async function verifyAndEmail() {
        const btn     = document.getElementById('verifyBtn');
        const success = document.getElementById('successPanel');
        const status  = document.getElementById('apiStatus');

        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing Email...';
        btn.disabled = true;

        const response = await fetch('{{ route("verify.nid") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nid_number: "{{ $donor['nid'] }}",
                email: "{{ $donor['email'] }}",
                name: "{{ $donor['name'] }}"
            })
        });

        const result = await response.json();
        if (result.status === "SUCCESS") {
            status.innerText = "Completed";
            btn.classList.add('hidden');
            success.classList.remove('hidden');
            if (result.message) alert(result.message);
        } else {
            alert(result.message ?? 'Verification failed.');
            btn.innerHTML = "Verify & Send Welcome Email";
            btn.disabled = false;
        }
    }
</script>
</body>
</html>
