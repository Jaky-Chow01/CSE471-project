<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Diagnostic Centers</title>
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
            height: 400px;
            width: 100%;
            border-radius: 1rem;
        }

        .service-tag {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin: 0.125rem;
        }

        .price-card {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 0.75rem;
            margin: 0.25rem 0;
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
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
            <span class="text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="max-w-7xl mx-auto px-4 mt-4">
        <a href="{{ route('home') }}" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-800 mb-2">Diagnostic Centers</h1>
            <p class="text-gray-600 font-medium">Find nearby diagnostic centers with services, pricing, and contact information</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Centers List -->
            <div class="xl:col-span-2 space-y-6">
                @forelse($centers as $center)
                    <div onclick="showOnMap('{{ $center->name }}', '{{ $center->location }}')" class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white hover:shadow-lg transition cursor-pointer">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $center->name }}</h3>
                                    @if($center->emergency_services)
                                        <span class="bg-red-100 text-red-600 text-xs font-black px-2 py-1 rounded-full uppercase animate-pulse">24/7 Emergency</span>
                                    @endif
                                </div>
                                <p class="text-gray-600 font-medium text-sm mb-2">{{ $center->location }}</p>
                                @if($center->description)
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $center->description }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2 ml-4">
                                <button onclick="event.stopPropagation(); showOnMap('{{ $center->name }}', '{{ $center->location }}')"
                                        class="bg-red-100 text-red-600 p-3 rounded-xl hover:bg-red-200 transition">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </button>
                                <a href="tel:{{ $center->contactno }}"
                                   class="bg-green-100 text-green-600 p-3 rounded-xl hover:bg-green-200 transition">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Services -->
                        @if($center->services && count($center->services) > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-700 mb-2">Services Offered:</h4>
                                <div class="flex flex-wrap">
                                    @foreach($center->services as $service)
                                        <span class="service-tag">{{ $service }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Operating Hours -->
                        @if($center->operating_hours)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-700 mb-1">Operating Hours:</h4>
                                <p class="text-sm text-gray-600">{{ $center->operating_hours }}</p>
                            </div>
                        @endif

                        <!-- Pricing -->
                        @if($center->prices && count($center->prices) > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-bold text-gray-700 mb-2">Sample Pricing:</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach(array_slice($center->prices, 0, 6) as $service => $price)
                                        <div class="price-card">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-700">{{ $service }}</span>
                                                <span class="text-sm font-bold text-red-600">৳{{ $price }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Contact:</span> {{ $center->contactno }}
                            </div>
                            <button onclick="getDirections('{{ $center->location }}')"
                                    class="text-red-600 font-bold text-sm hover:text-red-700 transition">
                                Get Directions →
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white/50 backdrop-blur-sm rounded-[2rem] border-2 border-dashed border-gray-300">
                        <p class="text-gray-400 font-medium">No diagnostic centers found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Map Sidebar -->
            <div class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border border-white h-fit sticky top-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Find on Map</h2>
                <div id="map" class="rounded-xl shadow-inner"></div>
                <p class="text-xs text-gray-500 mt-3 text-center">Click on location buttons to view centers on the map</p>

                <!-- Quick Filters -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">Quick Filters</h3>
                    <div class="space-y-2">
                        <button onclick="filterCenters('emergency')" class="w-full text-left text-sm text-gray-600 hover:text-red-600 transition">
                            🚨 24/7 Emergency Services
                        </button>
                        <button onclick="filterCenters('blood-test')" class="w-full text-left text-sm text-gray-600 hover:text-red-600 transition">
                            🩸 Blood Tests Available
                        </button>
                        <button onclick="filterCenters('xray')" class="w-full text-left text-sm text-gray-600 hover:text-red-600 transition">
                            🏥 X-Ray & Imaging
                        </button>
                        <button onclick="showAllCenters()" class="w-full text-left text-sm text-gray-600 hover:text-red-600 transition font-medium">
                            📋 Show All Centers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Script -->
    <script>
        let map;
        let markers = [];
        let allCenters = @json($centers);

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

        async function showOnMap(centerName, location) {
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
                .bindPopup(`<div class="p-3 max-w-xs">
                    <h3 class="font-bold text-gray-900 text-sm mb-1">${centerName}</h3>
                    <p class="text-xs text-gray-600 mb-2">${result.display_name}</p>
                    <a href="tel:${getCenterPhone(centerName)}" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200 transition">📞 Call Now</a>
                </div>`)
                .openPopup();

            markers.push(marker);

            // Center map on the location
            map.setView([result.lat, result.lng], 15);
        }

        function getCenterPhone(centerName) {
            const center = allCenters.find(c => c.name === centerName);
            return center ? center.contactno : '';
        }

        function getDirections(location) {
            // Try to get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const url = `https://www.openstreetmap.org/directions?engine=graphhopper_car&route=${userLat},${userLng};${encodeURIComponent(location + ', Bangladesh')}`;
                    window.open(url, '_blank');
                }, () => {
                    // Fallback: just search for the location
                    const url = `https://www.openstreetmap.org/search?query=${encodeURIComponent(location + ', Bangladesh')}`;
                    window.open(url, '_blank');
                });
            } else {
                // Fallback: just search for the location
                const url = `https://www.openstreetmap.org/search?query=${encodeURIComponent(location + ', Bangladesh')}`;
                window.open(url, '_blank');
            }
        }

        function filterCenters(type) {
            // This would require more complex filtering logic
            // For now, just show a message
            alert(`Filtering by ${type} - This feature would filter centers by service type`);
        }

        function showAllCenters() {
            // Reset any filters and show all centers
            location.reload();
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();

            // Add some sample data if no centers exist
            @if($centers->isEmpty())
            setTimeout(() => {
                showOnMap('Sample Diagnostic Center', 'Dhaka Medical College, Dhaka');
            }, 1000);
            @endif
        });
    </script>

    <footer class="fixed bottom-0 left-0 right-0 bg-red-600 py-4 shadow-[0_-4px_20px_rgba(220,38,38,0.2)] z-50">
        <p class="text-white text-center font-bold text-sm tracking-wide">
            Quality healthcare diagnostics • Expert medical services
        </p>
    </footer>

</body>
</html>