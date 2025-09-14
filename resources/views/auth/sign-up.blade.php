<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Flowbite JS (includes Datepicker) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col md:flex-row-reverse">
        <!-- Right Side - Registration Form -->
        <div class="w-full md:w-1/2 p-8 flex items-center justify-center">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
                    <p class="text-gray-600 mt-2">Join our community today</p>
                </div>

                <form class="space-y-4" action="{{ route('sign-up.form') }}" method="post">
                    @csrf
                    <!-- Full Name -->
                    <div>
                        <label for="full-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="full-name" name="full_name"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="John Doe">
                        @error('full_name')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="you@example.com">
                        @error('email')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone-number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone-number" name="phone"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="+1 (555) 123-4567">
                        @error('phone')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Date of Birth (with Datepicker) -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <div class="relative">
                            <input type="text" id="dob" name="dob"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697] datepicker-input"
                                placeholder="Select date" datepicker id="default-datepicker">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('dob')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <!-- counsellor_name -->
                    <div>
                        <label for="counsellor_name" class="block text-sm font-medium text-gray-700">Counsellor
                            Name</label>
                        <div class="relative">
                            <input type="text" id="counsellor_name" name="counsellor_name"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697] datepicker-input"
                                placeholder="Counsellor Name">
                        </div>
                        @error('counsellor_name')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- university_name -->
                    <div>
                        <label for="university_name" class="block text-sm font-medium text-gray-700">University
                            Name</label>
                        <div class="relative">
                            <input type="text" id="university_name" name="university_name"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697] datepicker-input"
                                placeholder="University Name">
                        </div>
                        @error('university_name')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Date of Birth (with Datepicker) -->
                    {{-- <div>
                        <label for="year_of_admission" class="block text-sm font-medium text-gray-700">Year of Admission</label>
                        <div class="relative">
                            <input type="text" id="year_of_admission" name="year_of_admission"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697] datepicker-input"
                                placeholder="Year of Admission" datepicker>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-1">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('year_of_admission')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}

                    <div class="mb-6">
                        <label for="year_of_admission" class="block text-sm font-medium text-gray-700">Year of
                            Admission</label>
                        <div class="relative mt-1">
                            <select id="year_of_admission" name="year_of_admission"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary appearance-none">
                                <option value="" disabled selected>Select Year</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Select your year of admission from the dropdown</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="••••••••">
                        <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                        @error('password')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <input type="password" id="confirm-password" name="password_confirmation"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="••••••••">
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#374697] hover:bg-[#2a3a80] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#374697]">
                            Create Account
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-[#374697] hover:text-[#2a3a80]">Sign
                            in</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Left Side - Abstract Connection Animation -->
        <div
            class="hidden md:flex md:w-1/2 bg-gradient-to-br from-[#374697] to-[#2a3a80] items-center justify-center p-12 relative overflow-hidden">
            <!-- Floating circles background -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-full bg-white animate-float opacity-30"></div>
                <div class="absolute top-1/3 right-1/3 w-24 h-24 rounded-full bg-white animate-float opacity-20"
                    style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-1/4 right-1/4 w-40 h-40 rounded-full bg-white animate-float opacity-10"
                    style="animation-delay: 1s;"></div>
                <div class="absolute bottom-1/3 left-1/3 w-28 h-28 rounded-full bg-white animate-float opacity-15"
                    style="animation-delay: 1.5s;"></div>
            </div>

            <!-- Main animation container -->
            <div class="relative w-full h-full max-w-xl flex items-center justify-center">
                <!-- Data flow animation -->
                <div class="relative w-64 h-64">
                    <!-- Central hub -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse">
                            <svg class="w-48 h-48 text-[#a3b1e6]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <!-- Connection lines (animated) -->
                        <div class="relative w-64 h-64">
                            <!-- Horizontal line -->
                            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-[#a3b1e6] animate-pulse"></div>
                            <!-- Vertical line -->
                            <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-[#a3b1e6] animate-pulse"></div>
                            <!-- Diagonal lines -->
                            <div class="absolute top-0 left-0 w-full h-full">
                                <div class="absolute top-0 left-0 w-full h-full border-t-2 border-l-2 border-indigo-300 rounded-full animate-spin-slow"
                                    style="border-right-color: transparent; border-bottom-color: transparent;"></div>
                                <div class="absolute top-0 left-0 w-full h-full border-t-2 border-r-2 border-indigo-300 rounded-full animate-spin-slow-reverse"
                                    style="border-left-color: transparent; border-bottom-color: transparent;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Connection lines -->
                    <div class="absolute top-0 left-1/2 w-1 h-1/2 bg-white bg-opacity-50 animate-connection-line">
                    </div>
                    <div class="absolute right-0 top-1/2 w-1/2 h-1 bg-white bg-opacity-50 animate-connection-line"
                        style="animation-delay: 0.2s;"></div>
                    <div class="absolute bottom-0 left-1/2 w-1 h-1/2 bg-white bg-opacity-50 animate-connection-line"
                        style="animation-delay: 0.4s;"></div>
                    <div class="absolute left-0 top-1/2 w-1/2 h-1 bg-white bg-opacity-50 animate-connection-line"
                        style="animation-delay: 0.6s;"></div>

                    <!-- Floating data nodes -->
                    <div
                        class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white bg-opacity-80 shadow-md flex items-center justify-center animate-data-node">
                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <div class="absolute right-0 top-1/2 transform translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white bg-opacity-80 shadow-md flex items-center justify-center animate-data-node"
                        style="animation-delay: 0.3s;">
                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-8 h-8 rounded-full bg-white bg-opacity-80 shadow-md flex items-center justify-center animate-data-node"
                        style="animation-delay: 0.6s;">
                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                    </div>

                    <div class="absolute left-0 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white bg-opacity-80 shadow-md flex items-center justify-center animate-data-node"
                        style="animation-delay: 0.9s;">
                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>

                <!-- Text overlay -->
                <div class="absolute bottom-10 left-0 right-0 text-center text-white px-6">
                    <h2 class="text-2xl font-bold mb-2">Connect With Our Community</h2>
                    <p class="text-indigo-100">Join thousands of users worldwide</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes connection-line {
            0% {
                transform: scaleY(0);
                opacity: 0;
            }

            50% {
                transform: scaleY(1);
                opacity: 0.5;
            }

            100% {
                transform: scaleY(0);
                opacity: 0;
            }
        }

        @keyframes data-node {
            0% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0;
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                transform: translateY(calc(var(--ty) * -1)) translateX(calc(var(--tx) * -1)) scale(0.5);
                opacity: 0;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-connection-line {
            transform-origin: top;
            animation: connection-line 2s ease-in-out infinite;
        }

        .animate-data-node {
            --ty: 40px;
            --tx: 40px;
            animation: data-node 2s ease-in-out infinite;
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength::before {
            content: '';
            display: block;
            height: 100%;
            width: 0%;
            background: #ef4444;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .password-strength[data-strength="1"]::before {
            width: 25%;
            background: #ef4444;
        }

        .password-strength[data-strength="2"]::before {
            width: 50%;
            background: #f59e0b;
        }

        .password-strength[data-strength="3"]::before {
            width: 75%;
            background: #3b82f6;
        }

        .password-strength[data-strength="4"]::before {
            width: 100%;
            background: #10b981;
        }
    </style>

    <script>
        // Simple password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            let strength = 0;

            if (password.length > 0) strength++;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Cap at 4 for our CSS classes
            strength = Math.min(strength, 4);

            // Update the strength indicator
            const indicator = document.querySelector('.password-strength');
            if (indicator) {
                indicator.setAttribute('data-strength', strength);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const yearSelect = document.getElementById('year_of_admission');
            const currentYear = new Date().getFullYear();
            const startYear = 1950;

            // Add years from 1950 to current year
            for (let year = currentYear; year >= startYear; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }

            // Add change event listener
            yearSelect.addEventListener('change', function() {
                console.log('Selected year:', this.value);
            });
        });
    </script>
</body>

</html>
