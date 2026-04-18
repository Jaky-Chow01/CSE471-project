<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Home</title>
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

    @if(session('success'))
        <div id="success-banner" class="max-w-4xl mx-auto mt-6 px-4">
            <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-[2rem] shadow-sm">
                <div class="flex-shrink-0 text-emerald-700 mt-0.5">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                        <path d="M8.333 14.167L4.167 10l-1.25 1.25L8.333 16.667 16.25 8.75 15 7.5 8.333 14.167Z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Request Submitted</p>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('success-banner').remove()" class="text-emerald-700 hover:text-emerald-900 font-bold">Close</button>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
        <a href="{{ route('blood.types') }}" class="bg-white/60 backdrop-blur-md p-4 rounded-3xl border border-white flex items-center gap-4 hover:bg-white/90 transition shadow-sm">
            <div class="bg-red-100 p-3 rounded-2xl text-red-600">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C7 2 3 6 3 11s9 11 9 11 9-6 9-11-4-9-9-9zm0 15c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase">Learn</p>
                <p class="text-sm font-bold text-gray-800">Blood Types</p>
            </div>
        </a>

        <a href="{{ route('blood.banks') }}" class="bg-white/60 backdrop-blur-md p-4 rounded-3xl border border-white flex items-center gap-4 hover:bg-white/90 transition shadow-sm">
            <div class="bg-red-100 p-3 rounded-2xl text-red-600">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase">Emergency</p>
                <p class="text-sm font-bold text-gray-800">Blood Banks</p>
            </div>
        </a>

        <a href="{{ route('diagnostic.centers') }}" class="bg-white/60 backdrop-blur-md p-4 rounded-3xl border border-white flex items-center gap-4 hover:bg-white/90 transition shadow-sm">
            <div class="bg-red-100 p-3 rounded-2xl text-red-600">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase">Health Care</p>
                <p class="text-sm font-bold text-gray-800">Diagnostic Centers</p>
            </div>
        </a>
    </div>

    <div class="flex flex-col items-center justify-center mt-12 px-4 text-center">
        <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-sm py-8 px-10 max-w-2xl border border-white">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 leading-tight">
                Connect with blood donors instantly,<br> 
                Save lives with a simple request.
            </h1>
        </div>

        <div class="mt-8 drop-shadow-xl animate-bounce">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
        </div>

        <a href="{{ route('blood.request.create') }}" 
           class="mt-6 bg-red-600 text-white font-bold py-4 px-12 rounded-2xl hover:bg-red-700 transition-all duration-300 shadow-xl shadow-red-200 active:scale-95 text-lg">
            Find blood now
        </a>
    </div>

    <div class="max-w-2xl mx-auto mt-16 px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">Live Announcements</h2>
            <div class="h-1 flex-grow mx-4 bg-gray-200/50 rounded-full"></div>
        </div>

        <div class="space-y-4">
            @forelse($announcements as $request)
                <div onclick="openRequestModal({{ $request->id }}, '{{ $request->bloodgroup }}', '{{ $request->location }}', '{{ $request->patienttype }}', '{{ $request->patientage }}', '{{ $request->contactno }}', '{{ $request->urgent }}', '{{ $request->created_at->format('Y-m-d H:i:s') }}')" class="bg-white/90 backdrop-blur-sm p-6 rounded-[2rem] shadow-sm border-l-8 {{ $request->urgent == 'Urgent' ? 'border-red-600' : 'border-gray-300' }} cursor-pointer hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex justify-between items-start">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xl font-extrabold text-gray-900">{{ $request->bloodgroup }} Needed</span>
                                @if($request->urgent == 'Urgent')
                                    <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-0.5 rounded-full uppercase animate-pulse">Urgent</span>
                                @endif
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">{{ $request->location }}</p>
                            <p class="text-xs text-gray-400">Request for {{ $request->patienttype }} patient (Age: {{ $request->patientage }})</p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800 mb-1">{{ $request->contactno }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                {{ $request->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white/50 backdrop-blur-sm rounded-[2rem] border-2 border-dashed border-gray-300">
                    <p class="text-gray-400 font-medium">No active blood requests found.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Global Leaderboard Section -->
    <div class="max-w-2xl mx-auto mt-16 px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">🏆 Global Leaderboard</h2>
            <div class="h-1 flex-grow mx-4 bg-gray-200/50 rounded-full"></div>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-[2rem] shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-md font-bold text-gray-700 mb-4">Top 10 Donors by Lifetime Donations</h3>
                <div class="space-y-3">
                    @forelse($topDonors as $index => $donor)
                        <div class="flex items-center justify-between p-3 {{ $index < 3 ? 'bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400' : 'bg-gray-50' }} rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-400' : ($index == 1 ? 'bg-gray-400' : ($index == 2 ? 'bg-amber-600' : 'bg-gray-200')) }} text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $donor->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $donor->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-red-600">{{ $donor->total_bags ?? 0 }} bags</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400 font-medium">No donations recorded yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed bottom-0 left-0 right-0 bg-red-600 py-4 shadow-[0_-4px_15px_rgba(220,38,38,0.2)] z-50">
        <p class="text-white text-center font-bold text-sm tracking-wide">
            Every drop counts. Your request could save a life.
        </p>
    </footer>

    <!-- Request Details Modal -->
    <div id="requestModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-900">Blood Request Details</h2>
                        <button onclick="closeRequestModal()" class="text-gray-400 hover:text-gray-600 transition">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Request Information -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Request Information</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Blood Group Needed:</span>
                                        <span id="modal-bloodgroup" class="text-lg font-bold text-red-600"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Location:</span>
                                        <span id="modal-location" class="text-sm font-semibold text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Patient Type:</span>
                                        <span id="modal-patienttype" class="text-sm font-semibold text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Patient Age:</span>
                                        <span id="modal-patientage" class="text-sm font-semibold text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Contact Number:</span>
                                        <span id="modal-contact" class="text-sm font-semibold text-gray-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Urgency:</span>
                                        <span id="modal-urgent" class="text-sm font-semibold"></span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                        <span class="text-sm font-medium text-gray-600">Posted:</span>
                                        <span id="modal-created" class="text-sm font-semibold text-gray-900"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <a id="call-button" href="#" class="w-full bg-green-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-green-700 transition flex items-center justify-center gap-2">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                    </svg>
                                    Call Now
                                </a>
                                <button onclick="getDirections()" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    Get Directions
                                </button>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Location on Map</h3>
                            <div id="modal-map" class="w-full h-80 rounded-xl shadow-inner"></div>
                            <p class="text-xs text-gray-500 mt-2">Click on the map marker for more details</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal Functionality -->
    <script>
        let modalMap;
        let currentRequestLocation = '';

        // Initialize modal map
        function initModalMap() {
            if (modalMap) {
                modalMap.remove();
            }

            modalMap = L.map('modal-map').setView([23.6850, 90.3563], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(modalMap);

            const customIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            window.modalCustomIcon = customIcon;
        }

        // Open request modal
        async function openRequestModal(id, bloodgroup, location, patienttype, patientage, contact, urgent, created) {
            // Populate modal data
            document.getElementById('modal-bloodgroup').textContent = bloodgroup;
            document.getElementById('modal-location').textContent = location;
            document.getElementById('modal-patienttype').textContent = patienttype;
            document.getElementById('modal-patientage').textContent = patientage;
            document.getElementById('modal-contact').textContent = contact;
            document.getElementById('modal-created').textContent = new Date(created).toLocaleString();

            // Set urgency styling
            const urgentElement = document.getElementById('modal-urgent');
            if (urgent === 'Urgent') {
                urgentElement.textContent = 'URGENT';
                urgentElement.className = 'text-sm font-bold text-red-600 bg-red-100 px-2 py-1 rounded-full';
            } else {
                urgentElement.textContent = 'Normal';
                urgentElement.className = 'text-sm font-semibold text-gray-600';
            }

            // Set call button href
            document.getElementById('call-button').href = `tel:${contact}`;

            // Store location for directions
            currentRequestLocation = location;

            // Initialize map
            setTimeout(() => {
                initModalMap();
                showLocationOnModalMap(location);
            }, 100);

            // Show modal
            document.getElementById('requestModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close request modal
        function closeRequestModal() {
            document.getElementById('requestModal').classList.add('hidden');
            document.body.style.overflow = 'auto';

            if (modalMap) {
                modalMap.remove();
                modalMap = null;
            }
        }

        // Show location on modal map
        async function showLocationOnModalMap(location) {
            if (!modalMap) return;

            const result = await geocodeLocation(location);
            if (!result) {
                alert('Could not find location: ' + location);
                return;
            }

            // Clear existing markers
            modalMap.eachLayer((layer) => {
                if (layer instanceof L.Marker) {
                    modalMap.removeLayer(layer);
                }
            });

            // Add marker
            const marker = L.marker([result.lat, result.lng], { icon: window.modalCustomIcon })
                .addTo(modalMap)
                .bindPopup(`<div class="p-2">
                    <h3 class="font-bold text-gray-900">${location}</h3>
                    <p class="text-sm text-gray-600">Blood request location</p>
                </div>`)
                .openPopup();

            // Center map
            modalMap.setView([result.lat, result.lng], 15);
        }

        // Geocode location using Nominatim
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

        // Get directions to the request location
        function getDirections() {
            if (!currentRequestLocation) return;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const url = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${encodeURIComponent(currentRequestLocation + ', Bangladesh')}&travelmode=driving`;
                    window.open(url, '_blank');
                }, () => {
                    // Fallback: just search for the location in Google Maps
                    const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(currentRequestLocation + ', Bangladesh')}`;
                    window.open(url, '_blank');
                });
            } else {
                // Fallback: just search for the location in Google Maps
                const url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(currentRequestLocation + ', Bangladesh')}`;
                window.open(url, '_blank');
            }
        }

        // Close modal when clicking outside
        document.getElementById('requestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRequestModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('requestModal').classList.contains('hidden')) {
                closeRequestModal();
            }
        });
    </script>

</body>
</html>