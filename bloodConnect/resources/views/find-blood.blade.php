<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Submit Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
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
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-1200px) rotate(360deg); }
        }

        /* Google Autocomplete Dropdown Styling */
        .pac-container {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            border: 1px solid white;
            margin-top: 8px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 10px 0;
        }
        .pac-item { padding: 12px 20px; border-top: 1px solid #f3f4f6; cursor: pointer; }
        .pac-item:hover { background-color: #fef2f2; }
        .pac-item-query { font-weight: 700; color: #1f2937; }
        .pac-matched { color: #dc2626; }
    </style>
</head>
<body class="min-h-screen p-6 relative">

    <!-- Background Particles -->
    <div class="blood-particle" style="width: 30px; height: 30px; left: 10%; animation-duration: 20s;"></div>
    <div class="blood-particle" style="width: 50px; height: 45px; left: 70%; animation-duration: 30s; border-radius: 40%;"></div>

    <div class="max-w-2xl mx-auto mt-4">
        <a href="{{ route('home') }}" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>

        <div class="bg-white/80 backdrop-blur-md p-8 md:p-10 rounded-[3rem] shadow-xl border border-white">
            <form action="{{ route('blood.request.store') }}" method="POST" id="bloodRequestForm">
                @csrf
                
                <!-- Hidden Coordinates Fields -->
                <input type="hidden" name="latitude" id="lat">
                <input type="hidden" name="longitude" id="lng">

                <div class="bg-gray-100/80 rounded-full py-3 px-8 flex justify-between items-center mb-8 border border-gray-200">
                    <span class="text-gray-700 font-extrabold tracking-tight">Mark as urgent</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="urgent" value="1" class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-300 rounded-full peer peer-checked:bg-red-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Blood Type</label>
                        <select name="bloodgroup" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700 appearance-none cursor-pointer">
                            <option disabled selected>Select blood group</option>
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Location (Google Maps)</label>
                        <input type="text" name="location" id="location-input" required 
                               placeholder="Search Hospital or City..." 
                               class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Required Date/Time</label>
                        <input type="datetime-local" name="datetime" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Number of Bags</label>
                        <input type="number" name="noofbags" required placeholder="e.g. 2" class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Patient Status</label>
                        <select name="patienttype" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700 cursor-pointer">
                            <option disabled selected>Patient Type</option>
                            <option value="Critical">Critical</option>
                            <option value="Stable">Stable</option>
                            <option value="Post-Surgery">Post-Surgery</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Patient Age</label>
                        <input type="number" name="patientage" required placeholder="Age" class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Patient Gender</label>
                        <select name="patientgender" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700 cursor-pointer">
                            <option disabled selected>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Emergency Contact</label>
                        <input type="text" name="contactno" required placeholder="017XXXXXXXX" class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>
                </div>

                <button type="submit" class="w-full mt-10 bg-red-600 text-white font-extrabold py-4 rounded-full hover:bg-red-700 transition duration-300 shadow-xl shadow-red-200 active:scale-95 text-lg">
                    Submit Blood Request
                </button>
            </form>
        </div>

        <p class="text-center text-gray-400 text-[10px] mt-8 font-black uppercase tracking-[0.3em]">
            Privacy Secure • Emergency Verified
        </p>
    </div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
    <script>
        function initAutocomplete() {
            const input = document.getElementById('location-input');
            const options = {
                componentRestrictions: { country: "BD" }, // Restrict to Bangladesh
                fields: ["formatted_address", "geometry", "name"],
                strictBounds: false,
                types: ["establishment", "geocode"]
            };

            const autocomplete = new google.maps.places.Autocomplete(input, options);

            // Prevent form submission when pressing Enter in Google search
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') e.preventDefault();
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                
                if (!place.geometry || !place.geometry.location) {
                    return;
                }

                // Fill coordinates to hidden fields
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
                
                // Set input to the full formatted address
                input.value = place.formatted_address;
            });
        }

        window.onload = initAutocomplete;
    </script>
</body>
</html>