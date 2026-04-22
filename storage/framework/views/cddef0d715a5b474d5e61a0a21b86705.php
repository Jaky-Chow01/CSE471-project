<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Blood Banks</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fdf2f2;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm66-3c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm-40-39c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm13-11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23dc2626' fill-opacity='0.04' fill-rule='evenodd'/%3E%3C/svg%3E");
            overflow-x: hidden;
        }

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

        #map {
            height: 260px;
            width: 100%;
            border-radius: 1rem;
        }
        @media (min-width: 640px) { #map { height: 400px; } }
    </style>
</head>
<body class="min-h-screen pb-24 relative">

    <div class="blood-particle" style="width: 25px; height: 25px; left: 5%; animation-duration: 18s;"></div>
    <div class="blood-particle" style="width: 45px; height: 40px; left: 20%; animation-duration: 28s; border-radius: 45%;"></div>
    <div class="blood-particle" style="width: 15px; height: 15px; left: 55%; animation-duration: 22s;"></div>
    <div class="blood-particle" style="width: 35px; height: 35px; left: 80%; animation-duration: 20s; border-radius: 35%;"></div>
    <div class="blood-particle" style="width: 55px; height: 50px; left: 45%; animation-duration: 35s; border-radius: 50%;"></div>

    <nav class="px-4 sm:p-6 flex items-center justify-between max-w-7xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
            <span class="text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="max-w-6xl mx-auto px-4 mt-4">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>

        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-black text-gray-800 mb-2">Blood Banks Near You</h1>
            <p class="text-gray-600 font-medium text-sm sm:text-base">Find emergency blood banks and contact them instantly</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Blood Banks List -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Available Blood Banks</h2>

                <?php $__empty_1 = true; $__currentLoopData = $bloodbanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div onclick="showOnMap('<?php echo e($bank->name); ?>', '<?php echo e($bank->location); ?>')" class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white hover:shadow-lg transition cursor-pointer">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($bank->name); ?></h3>
                                <p class="text-gray-600 font-medium text-sm"><?php echo e($bank->location); ?></p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="event.stopPropagation(); showOnMap('<?php echo e($bank->name); ?>', '<?php echo e($bank->location); ?>')"
                                        class="bg-red-100 text-red-600 p-2 rounded-xl hover:bg-red-200 transition">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </button>
                                <a href="tel:<?php echo e($bank->contactno); ?>"
                                   class="bg-green-100 text-green-600 p-2 rounded-xl hover:bg-green-200 transition">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Contact:</span> <?php echo e($bank->contactno); ?>

                            </div>
                            <button onclick="getDirections('<?php echo e($bank->location); ?>')"
                                    class="text-red-600 font-bold text-sm hover:text-red-700 transition">
                                Get Directions →
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-10 bg-white/50 backdrop-blur-sm rounded-[2rem] border-2 border-dashed border-gray-300">
                        <p class="text-gray-400 font-medium">No blood banks found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Google Maps -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Find on Map</h2>
                <div id="map" class="rounded-xl shadow-inner"></div>
                <p class="text-xs text-gray-500 mt-2 text-center">Click on location buttons to view blood banks on the map</p>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Script -->
    <script>
        let map;
        let markers = [];

        // Initialize Leaflet map
        function initMap() {
            // Initialize map centered on Bangladesh
            map = L.map('map').setView([23.6850, 90.3563], 7); // Dhaka coordinates

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Add custom marker icon
            const customIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Store custom icon for later use
            window.customIcon = customIcon;
        }

        // Geocode location using Nominatim (OpenStreetMap)
        async function geocodeLocation(location) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(location + ', Bangladesh')}&limit=1`);
                const data = await response.json();
                if (data && data.length > 0) {
                    return {
                        lat: parseFloat(data[0].lat),
                        lng: parseFloat(data[0].lon),
                        display_name: data[0].display_name
                    };
                }
                return null;
            } catch (error) {
                console.error('Geocoding error:', error);
                return null;
            }
        }

        async function showOnMap(bankName, location) {
            const result = await geocodeLocation(location);
            if (!result) {
                alert('Could not find location: ' + location);
                return;
            }

            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            // Add new marker
            const marker = L.marker([result.lat, result.lng], { icon: window.customIcon })
                .addTo(map)
                .bindPopup(`<div class="p-2">
                    <h3 class="font-bold text-gray-900">${bankName}</h3>
                    <p class="text-sm text-gray-600">${result.display_name}</p>
                </div>`)
                .openPopup();

            markers.push(marker);

            // Center map on the location
            map.setView([result.lat, result.lng], 15);
        }

        function getDirections(location) {
            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const url = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${encodeURIComponent(location + ', Bangladesh')}&travelmode=driving`;
                    window.open(url, '_blank');
                }, () => {
                    // Fallback: just search for the location in Google Maps
                    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(location + ', Bangladesh')}`;
                    window.open(url, '_blank');
                });
            } else {
                // Fallback: just search for the location in Google Maps
                const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(location + ', Bangladesh')}`;
                window.open(url, '_blank');
            }
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            // Add some sample data if no blood banks exist
            <?php if($bloodbanks->isEmpty()): ?>
            setTimeout(() => {
                showOnMap('Sample Blood Bank', 'Dhaka Medical College, Dhaka');
            }, 1000);
            <?php endif; ?>
        });
    </script>

    <footer class="fixed bottom-0 left-0 right-0 bg-red-600 py-4 shadow-[0_-4px_20px_rgba(220,38,38,0.2)] z-50">
        <p class="text-white text-center font-bold text-sm tracking-wide">
            Emergency blood supply • 24/7 Support
        </p>
    </footer>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\bloodConnect\resources\views/blood-banks.blade.php ENDPATH**/ ?>