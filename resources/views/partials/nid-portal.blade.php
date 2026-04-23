<div class="max-w-5xl mx-auto px-4 mt-4">

    <div class="mb-6">
        <h2 class="text-2xl font-black text-gray-800">NID Verification Portal</h2>
        <p class="text-gray-500 text-sm mt-1">Upload a donor's National ID card for verification and automatic email notification.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Upload --}}
        <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] shadow-xl border border-white">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-5">Step 1: Upload NID Front</p>
            <div class="aspect-video bg-gray-100 rounded-2xl border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden cursor-pointer hover:border-red-400 transition" onclick="document.getElementById('nid-file-input').click()">
                <img id="nid-preview" src="https://placehold.co/600x340/fdf2f2/dc2626?text=Click+to+Upload+NID" class="w-full h-full object-cover rounded-2xl">
            </div>
            <input type="file" id="nid-file-input" class="hidden" accept="image/*" onchange="processNidFile(event)">
            <button onclick="document.getElementById('nid-file-input').click()" class="mt-5 w-full bg-gray-800 hover:bg-gray-900 text-white py-3 rounded-2xl font-black text-sm transition active:scale-95">
                <i class="fa-solid fa-camera mr-2"></i>Select NID Image
            </button>
        </div>

        {{-- Verify --}}
        <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] shadow-xl border border-white">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-5">Step 2: AI Verification</p>

            <div id="nid-scan-zone" class="hidden mb-5">
                <p class="text-[10px] font-black text-blue-600 mb-2 uppercase tracking-wide">Scanning NID Text via API...</p>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="nid-scan-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width:0%"></div>
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
                    <span id="nid-api-status" class="text-xs font-black text-red-600 uppercase tracking-wide">Idle</span>
                </div>
            </div>

            <button id="nid-verify-btn" disabled onclick="verifyAndEmail()"
                    class="w-full bg-gray-200 text-gray-400 font-black py-4 rounded-2xl cursor-not-allowed transition-all text-sm">
                Verify &amp; Send Welcome Email
            </button>

            <div id="nid-success-panel" class="hidden mt-5 p-4 bg-emerald-500 rounded-2xl text-white text-center font-black text-sm animate-bounce">
                <i class="fa-solid fa-check-circle mr-2"></i>VERIFIED &amp; EMAIL SENT
            </div>
        </div>
    </div>
</div>

<script>
    async function processNidFile(event) {
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
        if (data.status === 'SUCCESS') runNidScanAnimation();
    }

    function runNidScanAnimation() {
        const zone   = document.getElementById('nid-scan-zone');
        const bar    = document.getElementById('nid-scan-bar');
        const btn    = document.getElementById('nid-verify-btn');
        const status = document.getElementById('nid-api-status');
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
        const btn     = document.getElementById('nid-verify-btn');
        const success = document.getElementById('nid-success-panel');
        const status  = document.getElementById('nid-api-status');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>Processing Email...';
        btn.disabled  = true;
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
            btn.disabled  = false;
        }
    }
</script>
