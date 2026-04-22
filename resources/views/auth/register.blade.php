<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.07; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
        .role-card input[type="radio"]:checked + label { border-color: #dc2626; background: #fef2f2; }
        .role-card input[type="radio"]:checked + label .role-icon { background: #fecaca; color: #dc2626; }
        #location-map { border-radius: 1rem; border: 2px solid #fca5a5; margin-top: 8px; }
        .leaflet-container { border-radius: 1rem; }
        #map-suggestions { position: absolute; z-index: 9999; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); max-height: 180px; overflow-y: auto; display: none; }
    </style>
</head>
<body class="min-h-screen flex flex-col relative">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const roles = document.querySelectorAll('input[name="role"]');
        const donorFields = document.getElementById('donor-fields');

        let map, marker, mapInitialized = false;
        let searchTimeout = null;

        function toggleDonorFields() {
            const isDonor = document.getElementById('role-donor').checked;
            donorFields.style.display = isDonor ? 'block' : 'none';
            if (isDonor && !mapInitialized) {
                setTimeout(initMap, 100);
            }
        }

        roles.forEach(r => r.addEventListener('change', toggleDonorFields));
        toggleDonorFields();

        function initMap() {
            if (mapInitialized) return;
            mapInitialized = true;
            const defaultLat = parseFloat(document.getElementById('latitude').value) || 23.8103;
            const defaultLng = parseFloat(document.getElementById('longitude').value) || 90.4125;

            map = L.map('location-map').setView([defaultLat, defaultLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const redIcon = L.divIcon({
                html: `<div style="background:#dc2626;width:18px;height:18px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 2px #dc2626,0 4px 12px rgba(220,38,38,0.4);cursor:grab;"></div>`,
                iconSize: [18, 18], iconAnchor: [9, 9], className: ''
            });

            marker = L.marker([defaultLat, defaultLng], { icon: redIcon, draggable: true }).addTo(map);

            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                reverseGeocode(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            const oldLocation = document.getElementById('location-hidden').value;
            if (oldLocation) {
                document.getElementById('location-text').textContent = oldLocation;
                document.getElementById('map-search-input').value = oldLocation;
            }
        }

        function reverseGeocode(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('location-text').textContent = 'Fetching address…';
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=14`)
                .then(r => r.json())
                .then(data => {
                    const short = buildShortAddress(data);
                    document.getElementById('location-hidden').value = short;
                    document.getElementById('location-text').textContent = short;
                    document.getElementById('map-search-input').value = short;
                })
                .catch(() => {
                    const fallback = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                    document.getElementById('location-hidden').value = fallback;
                    document.getElementById('location-text').textContent = fallback;
                });
        }

        function buildShortAddress(data) {
            const a = data.address || {};
            const parts = [
                a.suburb || a.neighbourhood || a.village || a.town,
                a.city || a.county,
                a.state
            ].filter(Boolean);
            return parts.length ? parts.join(', ') : (data.display_name || 'Unknown location');
        }

        // Search box
        const searchInput = document.getElementById('map-search-input');
        const suggestionsBox = document.getElementById('map-suggestions');

        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const q = this.value.trim();
            if (q.length < 3) { suggestionsBox.style.display = 'none'; return; }
            searchTimeout = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q + ', Bangladesh')}&limit=5&countrycodes=BD`)
                    .then(r => r.json())
                    .then(results => {
                        if (!results.length) { suggestionsBox.style.display = 'none'; return; }
                        suggestionsBox._results = results;
                        suggestionsBox.innerHTML = results.map((res, i) =>
                            `<div class="px-4 py-2.5 text-sm text-gray-700 font-semibold hover:bg-red-50 cursor-pointer border-b border-gray-100 last:border-0" data-i="${i}">${res.display_name}</div>`
                        ).join('');
                        suggestionsBox.style.display = 'block';
                    });
            }, 350);
        });

        suggestionsBox.addEventListener('click', function (e) {
            const el = e.target.closest('[data-i]');
            if (!el) return;
            const res = suggestionsBox._results[+el.dataset.i];
            const lat = parseFloat(res.lat), lng = parseFloat(res.lon);
            if (!mapInitialized) initMap();
            setTimeout(() => {
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
                reverseGeocode(lat, lng);
            }, 150);
            suggestionsBox.style.display = 'none';
        });

        document.addEventListener('click', e => {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.style.display = 'none';
            }
        });
    });
    </script>
    <div class="blood-particle" style="width:20px;height:20px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:35px;height:35px;left:75%;animation-duration:28s;border-radius:40%;"></div>

    <nav class="px-6 py-4 flex items-center justify-between max-w-4xl mx-auto w-full">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">

            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-3xl bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-user-plus text-red-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800">Create your account</h1>
                <p class="text-sm text-gray-500 mt-1">Join bloodConnect and help save lives</p>
            </div>

            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 font-bold">
                <i class="fa-solid fa-circle-exclamation mr-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-xl border border-white p-8">
                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    {{-- Role Selection --}}
                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-3">I am joining as</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="role-card">
                                <input type="radio" name="role" id="role-donor" value="donor" class="sr-only"
                                       {{ old('role') === 'donor' ? 'checked' : '' }}>
                                <label for="role-donor" class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-gray-50 cursor-pointer transition hover:border-red-300">
                                    <div class="role-icon w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center transition">
                                        <i class="fa-solid fa-user-nurse"></i>
                                    </div>
                                    <span class="text-sm font-black text-gray-700">I am a Donor</span>
                                    <span class="text-[10px] text-gray-400 text-center leading-relaxed">I want to donate blood</span>
                                </label>
                            </div>
                            <div class="role-card">
                                <input type="radio" name="role" id="role-requester" value="requester" class="sr-only"
                                       {{ old('role', 'requester') === 'requester' ? 'checked' : '' }}>
                                <label for="role-requester" class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-gray-50 cursor-pointer transition hover:border-red-300">
                                    <div class="role-icon w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center transition">
                                        <i class="fa-solid fa-person-half-dress"></i>
                                    </div>
                                    <span class="text-sm font-black text-gray-700">I Need Blood</span>
                                    <span class="text-[10px] text-gray-400 text-center leading-relaxed">I want to request blood</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="Your full name">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="At least 8 characters">
                    </div>

                    <div>
                        <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                               placeholder="Repeat your password">
                    </div>

                    {{-- Donor-specific fields --}}
                    <div id="donor-fields" style="display:none;" class="space-y-4 border-t border-red-100 pt-4">
                        <p class="text-xs font-black uppercase tracking-widest text-red-400">Donor Information</p>
                        <div>
                            <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Blood Group *</label>
                            <select name="blood_group"
                                    class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition">
                                <option value="">Select blood group…</option>
                                <option value="A+" {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Phone Number *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                                   placeholder="e.g. 01711-XXXXXX">
                        </div>
                        <div>
                            <label class="text-xs font-black uppercase tracking-widest text-gray-400 block mb-2">Location * <span class="normal-case font-normal text-gray-400">(Pin your location on the map)</span></label>
                            <div id="map-search-wrap" class="mb-2" style="position: relative;">
                                <input type="text" id="map-search-input"
                                       class="w-full px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 transition"
                                       placeholder="Search address or drag pin on map…"
                                       autocomplete="off">
                                <div id="map-suggestions"></div>
                            </div>
                            <div id="location-map" style="height: 280px;"></div>
                            <input type="hidden" name="location" id="location-hidden" value="{{ old('location') }}">
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', '23.8103') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', '90.4125') }}">
                            <p class="text-[10px] text-gray-400 mt-1 font-semibold" id="location-display">
                                <i class="fa-solid fa-location-dot text-red-400 mr-1"></i>
                                <span id="location-text">{{ old('location', 'Drag the pin or search to set your location') }}</span>
                            </p>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-2xl font-black text-sm transition active:scale-95 shadow-lg shadow-red-200">
                        <i class="fa-solid fa-user-plus mr-2"></i>Create Account
                    </button>
                </form>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="font-black text-red-600 hover:text-red-700 transition">Sign in here</a>
            </p>

        </div>
    </div>
</body>
</html>
