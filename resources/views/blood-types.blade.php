<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bloodConnect | Blood Types Knowledge</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fdf2f2;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm66-3c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm-40-39c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm13-11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23dc2626' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="p-4 sm:p-6 pb-20">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 sm:mb-12">
            <a href="{{ route('home') }}" class="flex items-center text-gray-600 font-bold hover:text-red-600 transition group">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
            <div class="sm:text-right">
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Blood Group Insights</h1>
                <p class="text-sm text-gray-500 font-medium">Understanding compatibility saves lives.</p>
            </div>
        </div>

        <!-- Know Your Blood Group Section -->
        <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] border border-white shadow-lg mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-gray-900 mb-2">Know Your Blood Group</h2>
                <p class="text-gray-600 font-medium">Don't know your blood type? Visit a blood bank or diagnostic center to find out!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
                <a href="{{ route('blood.banks') }}" class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-[2rem] hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Blood Banks</h3>
                        <p class="text-sm opacity-90">Visit a blood bank for blood group testing and donation</p>
                    </div>
                </a>

                <a href="{{ route('diagnostic.centers') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-[2rem] hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Diagnostic Centers</h3>
                        <p class="text-sm opacity-90">Get comprehensive blood tests and health diagnostics</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @php
                $bloodData = [
                    [
                        'type' => 'A+', 
                        'give' => 'A+, AB+', 
                        'receive' => 'A+, A-, O+, O-',
                        'desc' => 'One of the most common types. High demand for routine surgeries.',
                        'fact' => '35.7% of people have this type.'
                    ],
                    [
                        'type' => 'O+', 
                        'give' => 'O+, A+, B+, AB+', 
                        'receive' => 'O+, O-',
                        'desc' => 'The most common blood type. Essential for almost every hospital.',
                        'fact' => 'Can be given to anyone with a positive blood type.'
                    ],
                    [
                        'type' => 'B+', 
                        'give' => 'B+, AB+', 
                        'receive' => 'B+, B-, O+, O-',
                        'desc' => 'Frequently needed for Thalassemia patients in South Asia.',
                        'fact' => 'Very common in Bangladesh and surrounding regions.'
                    ],
                    [
                        'type' => 'AB+', 
                        'give' => 'AB+ Only', 
                        'receive' => 'All Types',
                        'desc' => 'Known as the Universal Recipient. Can receive any blood type safely.',
                        'fact' => 'Your plasma is the universal type for all patients.'
                    ],
                    [
                        'type' => 'A-', 
                        'give' => 'A+/-, AB+/-', 
                        'receive' => 'A-, O-',
                        'desc' => 'A rare type. Crucial for matching other negative blood types.',
                        'fact' => 'Only 6.3% of the world population has this.'
                    ],
                    [
                        'type' => 'O-', 
                        'give' => 'All Types', 
                        'receive' => 'O- Only',
                        'desc' => 'The Universal Donor. Used in emergency rooms for trauma patients.',
                        'fact' => 'Critical when the patient’s blood type is unknown.'
                    ],
                    [
                        'type' => 'B-', 
                        'give' => 'B+/-, AB+/-', 
                        'receive' => 'B-, O-',
                        'desc' => 'Extremely rare. Finding a donor for B- can be a challenge.',
                        'fact' => 'Only 1.5% of people have this type.'
                    ],
                    [
                        'type' => 'AB-', 
                        'give' => 'AB+/-,', 
                        'receive' => 'AB-, A-, B-, O-',
                        'desc' => 'The rarest blood type. Plasma is in extremely high demand.',
                        'fact' => 'Only 0.6% of the population has this group.'
                    ]
                ];
            @endphp

            @foreach($bloodData as $data)
            <div class="bg-white/80 backdrop-blur-md p-8 rounded-[3rem] border border-white shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-16 h-16 bg-red-600 rounded-3xl flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-red-200">
                        {{ $data['type'] }}
                    </div>
                    <span class="text-[10px] font-black bg-red-50 text-red-600 px-3 py-1 rounded-full uppercase tracking-widest">
                        Bio-Data
                    </span>
                </div>
                
                <p class="text-sm font-bold text-gray-800 mb-2 leading-tight">{{ $data['desc'] }}</p>
                <p class="text-xs text-gray-500 mb-6 italic">"{{ $data['fact'] }}"</p>

                <div class="mt-auto space-y-4">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Donor To</p>
                        <p class="text-sm font-extrabold text-red-600">{{ $data['give'] }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Recipient From</p>
                        <p class="text-sm font-extrabold text-gray-700">{{ $data['receive'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 sm:mt-16 bg-white/40 backdrop-blur-xl rounded-[3rem] sm:rounded-[4rem] p-6 sm:p-10 border border-white text-center">
            <h3 class="text-lg sm:text-xl font-black text-gray-800 mb-2">Ready to save a life?</h3>
            <p class="text-gray-500 text-sm mb-6 sm:mb-8 max-w-md mx-auto font-medium">Knowing your type is the first step. The second step is taking action when someone is in need.</p>
            <a href="{{ route('blood.request.create') }}" class="inline-block bg-red-600 text-white px-8 sm:px-10 py-4 rounded-full font-bold shadow-lg shadow-red-100 hover:bg-red-700 transition active:scale-95">
                Post a Request
            </a>
        </div>
    </div>
</body>
</html>
