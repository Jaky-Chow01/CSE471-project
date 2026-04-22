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

        .pac-container {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            border: 1px solid white;
            margin-top: 8px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 10px 0;
            z-index: 9999;
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
    </style>
</head>
<body class="min-h-screen p-4 sm:p-6 relative">

    <div class="blood-particle" style="width: 30px; height: 30px; left: 10%; animation-duration: 20s;"></div>
    <div class="blood-particle" style="width: 50px; height: 45px; left: 80%; animation-duration: 30s; border-radius: 40%;"></div>

    <nav class="p-6 flex items-center justify-between max-w-7xl mx-auto">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 21.5C16.4183 21.5 20 17.9183 20 13.5C20 9.08172 12 2.5 12 2.5C12 2.5 4 9.08172 4 13.5C4 17.9183 7.58172 21.5 12 21.5Z" fill="#DC2626"/>
            </svg>
            <span class="text-2xl font-extrabold text-red-600 tracking-tight">bloodConnect</span>
        </a>
    </nav>

    <div class="max-w-2xl mx-auto mt-4">
        <a href="<?php echo e(route('home')); ?>" class="flex items-center text-gray-600 font-bold mb-6 hover:text-red-600 transition group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>

        <div class="bg-white/80 backdrop-blur-md p-6 sm:p-8 md:p-10 rounded-[3rem] shadow-xl border border-white">
            <h2 class="text-xl sm:text-2xl font-black text-gray-800 mb-6 sm:mb-8">Request Blood</h2>

            <form action="<?php echo e(route('blood.request.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="latitude" id="lat">
                <input type="hidden" name="longitude" id="lng">

                <div class="bg-gray-100/80 rounded-full py-3 px-4 sm:px-8 flex justify-between items-center mb-8 border border-gray-200">
                    <span class="text-gray-700 font-extrabold tracking-tight">Mark as urgent</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="urgent" value="Urgent" class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-300 rounded-full peer peer-checked:bg-red-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Blood Type</label>
                        <select name="bloodgroup" id="bloodgroup-select" onchange="updateBloodInfo()" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700 appearance-none cursor-pointer">
                            <option disabled selected>Select blood group</option>
                            <option value="A+">A+</option><option value="A-">A-</option>
                            <option value="B+">B+</option><option value="B-">B-</option>
                            <option value="O+">O+</option><option value="O-">O-</option>
                            <option value="AB+">AB+</option><option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div class="space-y-1 relative">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Location (Hospital/Area)</label>
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
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Patient Gender</label>
                        <select name="patientgender" required class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700 cursor-pointer">
                            <option disabled selected>Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Patient Age</label>
                        <input type="number" name="patientage" required placeholder="Age" class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black uppercase text-gray-400 ml-4 tracking-widest">Emergency Contact</label>
                        <input type="text" name="contactno" required placeholder="017XXXXXXXX" class="w-full bg-gray-100/80 rounded-full py-3 px-6 border-none focus:ring-2 focus:ring-red-500 outline-none font-semibold text-gray-700">
                    </div>
                </div>

                <div id="blood-info-card" class="hidden mt-6 bg-red-50/50 border border-red-100 p-5 rounded-[2rem] transition-all duration-500">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-600 text-white w-10 h-10 rounded-xl flex items-center justify-center font-black shrink-0 shadow-lg" id="info-badge">--</div>
                        <div>
                            <h4 class="text-sm font-extrabold text-red-600 uppercase tracking-tighter" id="info-title">Blood Fact</h4>
                            <p class="text-xs text-gray-600 leading-relaxed mt-1" id="info-text"></p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-10 bg-red-600 text-white font-extrabold py-4 rounded-full hover:bg-red-700 transition duration-300 shadow-xl shadow-red-200 active:scale-95 text-lg">
                    Submit Blood Request
                </button>
            </form>
        </div>

        <p class="text-center text-gray-400 text-[10px] mt-8 font-black uppercase tracking-[0.3em]">
            Verified Request System • Sylhet Zone
        </p>
    </div>

    <!-- Custom Autocomplete Script -->
    <script>
        // Custom autocomplete using Nominatim
        function initAutocomplete() {
            const input = document.getElementById('location-input');
            const suggestionsContainer = document.createElement('div');
            suggestionsContainer.id = 'autocomplete-suggestions';
            suggestionsContainer.className = 'absolute z-50 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto w-full mt-1';
            suggestionsContainer.style.display = 'none';
            input.parentNode.style.position = 'relative';
            input.parentNode.appendChild(suggestionsContainer);

            let currentFocus = -1;
            let suggestions = [];

            input.addEventListener('input', async function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    suggestionsContainer.style.display = 'none';
                    return;
                }

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Bangladesh')}&limit=5&countrycodes=BD`);
                    const data = await response.json();
                    suggestions = data;

                    if (suggestions.length > 0) {
                        suggestionsContainer.innerHTML = '';
                        suggestions.forEach((suggestion, index) => {
                            const div = document.createElement('div');
                            div.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                            div.textContent = suggestion.display_name;
                            div.addEventListener('click', () => {
                                input.value = suggestion.display_name;
                                document.getElementById('lat').value = suggestion.lat;
                                document.getElementById('lng').value = suggestion.lon;
                                suggestionsContainer.style.display = 'none';
                            });
                            suggestionsContainer.appendChild(div);
                        });
                        suggestionsContainer.style.display = 'block';
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Autocomplete error:', error);
                    suggestionsContainer.style.display = 'none';
                }
            });

            input.addEventListener('keydown', function(e) {
                if (suggestionsContainer.style.display === 'none') return;

                const items = suggestionsContainer.getElementsByTagName('div');

                if (e.keyCode === 40) { // Down arrow
                    currentFocus++;
                    if (currentFocus >= items.length) currentFocus = 0;
                    highlightItem(items, currentFocus);
                } else if (e.keyCode === 38) { // Up arrow
                    currentFocus--;
                    if (currentFocus < 0) currentFocus = items.length - 1;
                    highlightItem(items, currentFocus);
                } else if (e.keyCode === 13) { // Enter
                    e.preventDefault();
                    if (currentFocus > -1 && items[currentFocus]) {
                        items[currentFocus].click();
                    }
                }
            });

            function highlightItem(items, index) {
                for (let i = 0; i < items.length; i++) {
                    items[i].classList.remove('bg-gray-100');
                }
                if (items[index]) {
                    items[index].classList.add('bg-gray-100');
                }
            }

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== input && !suggestionsContainer.contains(e.target)) {
                    suggestionsContainer.style.display = 'none';
                }
            });
        }

        // 2. Dynamic Info Logic
        function updateBloodInfo() {
            const select = document.getElementById('bloodgroup-select');
            const card = document.getElementById('blood-info-card');
            const badge = document.getElementById('info-badge');
            const title = document.getElementById('info-title');
            const text = document.getElementById('info-text');

            const bloodData = {
                'A+': "A common and crucial type in Bangladesh! You can give to A+ and AB+.",
                'A-': "A rare and vital type. Only about 6% of the population carries this.",
                'B+': "Essential for surgeries! You can provide for B+ and AB+ recipients.",
                'B-': "Rare type! Matching donors are often hard to find during emergencies.",
                'O+': "The most needed type! 80% of people can receive your blood.",
                'O-': "The Universal Donor. Critical for trauma cases and neonatals.",
                'AB+': "The Universal Recipient. You can safely receive blood from any type.",
                'AB-': "The Rarest Type. Only 1 in 100 people share this life-saving group."
            };

            if (bloodData[select.value]) {
                badge.innerText = select.value;
                text.innerText = bloodData[select.value];
                title.innerText = select.value + " Compatibility Info";
                card.classList.remove('hidden');
                card.classList.add('animate-pulse');
                setTimeout(() => card.classList.remove('animate-pulse'), 800);
            }
        }

        function setDateTimeMin() {
            const input = document.querySelector('input[name="datetime"]');
            if (!input) return;

            const now = new Date();
            const pad = (value) => String(value).padStart(2, '0');
            const minDateTime = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}T${pad(now.getHours())}:${pad(now.getMinutes())}`;

            input.min = minDateTime;
        }

        function validateFutureDate(event) {
            const input = document.querySelector('input[name="datetime"]');
            if (!input || !input.value) return;

            const selected = new Date(input.value);
            const now = new Date();
            if (selected < now) {
                event.preventDefault();
                alert('Please choose a future date and time for your blood request.');
                input.focus();
            }
        }

        window.onload = () => {
            initAutocomplete();
            setDateTimeMin();
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', validateFutureDate);
            }
        };
    </script>
</body>
</html><?php  ?>
