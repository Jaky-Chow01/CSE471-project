<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Connect - Map Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        #map { height: 500px; width: 100%; border-radius: 12px; z-index: 1; }
        .user-marker { filter: hue-rotate(120deg); }
    </style>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow-md border-b border-gray-100 p-4 mb-6">
    <div class="max-w-4xl mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <i class="fa-solid fa-droplet text-red-600"></i>
            <span class="text-red-600 font-black text-xl">Blood Connect</span>
        </a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-red-600 font-bold text-sm">
                <i class="fa-solid fa-map-location-dot mr-1"></i>Find Donors
            </a>
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-bold text-sm">
                <i class="fa-solid fa-truck-fast mr-1"></i>Track Donation
            </a>
            <a href="{{ route('admin') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">
                <i class="fa-solid fa-shield-halved mr-1"></i>Admin: Verify NID
            </a>
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto px-4 pb-10">
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-red-600 mb-2">Blood Connect - Nearby Donors</h1>
        <p class="text-gray-600 mb-4 text-sm">Allow location access to see the distance and travel time from your current position.</p>

        <div class="flex gap-2 mb-4">
            <input id="bg_input" type="text" placeholder="Enter Blood Group (e.g., A+)"
                   class="border border-gray-300 p-3 flex-1 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
            <button onclick="searchDonors()"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">
                Search Nearby
            </button>
        </div>

        <div id="map" class="border-2 border-gray-200"></div>
    </div>

    <!-- Track Donation CTA -->
    <div class="mt-6 bg-white rounded-xl shadow border border-gray-100 p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-truck-fast text-red-600"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">Already have a donation in progress?</p>
                <p class="text-xs text-gray-500">Track your real-time donation status — donor, requester, or hospital staff.</p>
            </div>
        </div>
        <a href="{{ route('login') }}"
           class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition flex-shrink-0">
            <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Track Donation
        </a>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map = L.map('map').setView([23.8103, 90.4125], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let markersLayer = L.layerGroup().addTo(map);

    const DEFAULT_LAT = 23.8103;
    const DEFAULT_LNG = 90.4125;

    async function doSearch(bg, userLat, userLng, usingDefault) {
        const url = `/search_donors?blood_group=${encodeURIComponent(bg)}&lat=${userLat}&lng=${userLng}`;
        const response = await fetch(url);
        const data = await response.json();

        markersLayer.clearLayers();

        const userMarker = L.marker([userLat, userLng]).addTo(markersLayer);
        userMarker.bindPopup(usingDefault ? "<b>Default location (Dhaka)</b>" : "<b>You are here</b>").openPopup();
        userMarker._icon.classList.add("user-marker");

        if (data.donors_found.length === 0) {
            alert("No donors found for " + bg);
            return;
        }

        let bounds = L.latLngBounds();
        bounds.extend([userLat, userLng]);

        data.donors_found.forEach(donor => {
            const donorLatLng = [donor.location.lat, donor.location.lng];
            L.marker(donorLatLng)
                .bindPopup(`
                    <div class="text-center">
                        <b class="text-red-600 text-lg">${donor.name}</b><br>
                        <span class="font-bold">Group: ${bg}</span><br>
                        <hr class="my-1">
                        <b>Distance:</b> ${donor.distance}<br>
                        <b>Est. Time:</b> ${donor.travel_time}
                    </div>
                `)
                .addTo(markersLayer);
            bounds.extend(donorLatLng);
        });

        map.fitBounds(bounds, { padding: [70, 70], maxZoom: 15 });
    }

    async function searchDonors() {
        const bg = document.getElementById('bg_input').value.toUpperCase();
        if (!bg) { alert("Please enter a blood group!"); return; }

        if (!navigator.geolocation) {
            await doSearch(bg, DEFAULT_LAT, DEFAULT_LNG, true);
            return;
        }

        navigator.geolocation.getCurrentPosition(
            async (position) => {
                await doSearch(bg, position.coords.latitude, position.coords.longitude, false);
            },
            async () => {
                // Location denied or unavailable — fall back to Dhaka centre
                await doSearch(bg, DEFAULT_LAT, DEFAULT_LNG, true);
            },
            { timeout: 5000 }
        );
    }
</script>
</body>
</html>
