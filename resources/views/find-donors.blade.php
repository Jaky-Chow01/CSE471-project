<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Find Donors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf2f2; background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E"); overflow-x: hidden; }
        #map { height: 300px; width: 100%; border-radius: 1.5rem; z-index: 1; }
        @media (min-width: 640px) { #map { height: 460px; } }
        .blood-particle { position: fixed; background: #dc2626; border-radius: 50%; filter: blur(3px); opacity: 0.08; z-index: -1; bottom: -100px; animation: float 25s infinite linear; }
        @keyframes float { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(-1200px) rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen pb-24 relative">
    <div class="blood-particle" style="width:30px;height:30px;left:10%;animation-duration:20s;"></div>
    <div class="blood-particle" style="width:50px;height:45px;left:75%;animation-duration:30s;border-radius:40%;"></div>

    <nav class="px-4 sm:px-6 py-4 flex items-center justify-between max-w-7xl mx-auto">
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"><path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/></svg>
            <span class="text-xl sm:text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Home</a>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Dashboard</a>
            <a href="{{ route('admin.nid') }}" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Verify NID</a>
            <a href="{{ route('login') }}" class="ml-2 px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-2xl transition shadow-md shadow-red-200">Track Donation</a>
        </div>
        <!-- Mobile hamburger -->
        <button class="md:hidden p-2 rounded-xl hover:bg-red-50 transition" onclick="toggleMobileMenu()">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <!-- Mobile menu overlay -->
    <div id="mobile-menu" class="hidden fixed inset-0 z-50 md:hidden" onclick="if(event.target===this)toggleMobileMenu()">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
        <div class="absolute top-0 right-0 w-72 h-full bg-white shadow-2xl flex flex-col">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <span class="font-extrabold text-red-600 text-lg">Menu</span>
                <button onclick="toggleMobileMenu()" class="p-2 hover:bg-gray-100 rounded-xl transition">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-col gap-1 p-4 flex-1">
                <a href="{{ route('home') }}" class="px-4 py-3 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Home</a>
                <a href="{{ route('dashboard') }}" class="px-4 py-3 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Dashboard</a>
                <a href="{{ route('admin.nid') }}" class="px-4 py-3 text-sm font-bold text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition">Verify NID</a>
                <a href="{{ route('login') }}" class="px-4 py-3 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-2xl transition text-center mt-2">Track Donation</a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 mt-4">
        <a href="{{ route('home') }}" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>

        <div class="bg-white/80 backdrop-blur-md p-5 sm:p-8 rounded-[3rem] shadow-xl border border-white">
            <h2 class="text-xl sm:text-2xl font-black text-gray-800 mb-2">Find Nearby Donors</h2>
            <p class="text-gray-500 text-sm mb-6">Allow location access to see distance and travel time from your position.</p>

            <div class="flex flex-col sm:flex-row gap-3 mb-6">
                <div class="relative flex-1">
                    <select id="bg_input" class="w-full appearance-none bg-gray-100/80 border border-gray-200 rounded-2xl py-3 px-5 font-bold text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent">
                        <option value="">Select Blood Group</option>
                        <option>A+</option><option>A-</option>
                        <option>B+</option><option>B-</option>
                        <option>AB+</option><option>AB-</option>
                        <option>O+</option><option>O-</option>
                    </select>
                </div>
                <button onclick="searchDonors()" class="w-full sm:w-auto bg-red-600 text-white font-bold py-3 px-8 rounded-2xl hover:bg-red-700 transition-all duration-300 shadow-lg shadow-red-200 active:scale-95">
                    Search Nearby
                </button>
            </div>

            <div id="map" class="border border-white/50 shadow-inner"></div>
        </div>

        <!-- Results list -->
        <div id="results-panel" class="hidden mt-6 bg-white/80 backdrop-blur-md p-6 rounded-[2.5rem] shadow-xl border border-white">
            <h3 class="text-lg font-black text-gray-800 mb-4" id="results-title">Donors Found</h3>
            <div id="results-list" class="space-y-3"></div>
        </div>

        <!-- Track donation CTA -->
        <div class="mt-6 bg-white/70 backdrop-blur-md p-5 rounded-[2.5rem] border border-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-red-100 p-3 rounded-2xl text-red-600 flex-shrink-0">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Have a donation in progress?</p>
                    <p class="text-xs text-gray-500">Track real-time status as donor, requester, or hospital staff.</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-2xl text-sm transition shadow-lg shadow-red-200 flex-shrink-0">Track Donation →</a>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            document.body.style.overflow = menu.classList.contains('hidden') ? '' : 'hidden';
        }
    </script>
    <script>
        let map = L.map('map').setView([23.8103, 90.4125], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
        let markersLayer = L.layerGroup().addTo(map);
        const DEFAULT_LAT = 23.8103, DEFAULT_LNG = 90.4125;

        async function doSearch(bg, userLat, userLng, usingDefault) {
            const url = `/search_donors?blood_group=${encodeURIComponent(bg)}&lat=${userLat}&lng=${userLng}`;
            const resp = await fetch(url);
            const data = await resp.json();
            markersLayer.clearLayers();

            // User marker
            const userIcon = L.divIcon({ html: '<div style="background:#dc2626;width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 2px #dc2626;"></div>', iconSize:[14,14], iconAnchor:[7,7], className:'' });
            L.marker([userLat, userLng], { icon: userIcon }).addTo(markersLayer).bindPopup(usingDefault ? '<b>Default: Dhaka</b>' : '<b>You are here</b>').openPopup();

            const panel = document.getElementById('results-panel');
            const list  = document.getElementById('results-list');
            const title = document.getElementById('results-title');

            if (!data.donors_found || data.donors_found.length === 0) {
                title.textContent = 'No donors found for ' + bg;
                list.innerHTML = '<p class="text-gray-500 text-sm py-4 text-center">Try a different blood group or location.</p>';
                panel.classList.remove('hidden');
                return;
            }

            title.textContent = data.donors_found.length + ' Donor(s) Found for ' + bg;
            list.innerHTML = '';
            let bounds = L.latLngBounds().extend([userLat, userLng]);

            data.donors_found.forEach((donor, i) => {
                const ll = [donor.location.lat, donor.location.lng];
                const donorIcon = L.divIcon({ html: `<div style="background:#1d4ed8;width:12px;height:12px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 2px #1d4ed8;"></div>`, iconSize:[12,12], iconAnchor:[6,6], className:'' });
                L.marker(ll, { icon: donorIcon })
                    .bindPopup(`<div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:140px"><b style="color:#dc2626;font-size:15px">${donor.name}</b><br><span style="font-size:12px;color:#555">Blood: ${bg}</span><hr style="margin:5px 0"><span style="font-size:12px"><b>Distance:</b> ${donor.distance}</span><br><span style="font-size:12px"><b>Est. Time:</b> ${donor.travel_time}</span></div>`)
                    .addTo(markersLayer);
                bounds.extend(ll);

                list.innerHTML += `<div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-red-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 font-black text-sm">${bg}</div>
                        <div><p class="font-bold text-gray-800 text-sm">${donor.name}</p><p class="text-xs text-gray-500">${donor.distance} away</p></div>
                    </div>
                    <span class="text-xs font-bold text-gray-600 bg-white border border-gray-200 px-3 py-1 rounded-full">${donor.travel_time}</span>
                </div>`;
            });

            map.fitBounds(bounds, { padding: [60, 60], maxZoom: 15 });
            panel.classList.remove('hidden');
        }

        async function searchDonors() {
            const bg = document.getElementById('bg_input').value.trim().toUpperCase();
            if (!bg) { alert('Please select a blood group!'); return; }
            if (!navigator.geolocation) { await doSearch(bg, DEFAULT_LAT, DEFAULT_LNG, true); return; }
            navigator.geolocation.getCurrentPosition(
                async (p) => await doSearch(bg, p.coords.latitude, p.coords.longitude, false),
                async () => await doSearch(bg, DEFAULT_LAT, DEFAULT_LNG, true),
                { timeout: 5000 }
            );
        }
    </script>
</body>
</html>
