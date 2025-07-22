<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Side - Login Form -->
        <div class="w-full md:w-1/2 p-8 flex items-center justify-center">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
                    <p class="text-gray-600 mt-2">Sign in to your account</p>
                </div>
                <!-- Add this right below your welcome message div -->
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    {{ session('success') }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button"
                                        onclick="this.parentElement.parentElement.parentElement.remove()"
                                        class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <form class="space-y-6" method="post" action="{{ route('login.form') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="you@example.com">
                        @error('email')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-[#374697] focus:border-[#374697]"
                            placeholder="••••••••">
                        @error('password')
                            <span class="block text-sm text-red-600 mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-[#374697] focus:ring-[#374697] border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-[#374697] hover:text-[#2a3a80]">Forgot
                                password?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#374697] hover:bg-[#2a3a80] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#374697]">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('sign-up') }}" class="font-medium text-[#374697] hover:text-[#2a3a80]">Sign
                            up</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Network Animation -->
        <div
            class="hidden md:flex md:w-1/2 bg-gradient-to-br from-[#374697] to-[#2a3a80] items-center justify-center p-12">
            <div class="relative w-full h-full max-w-xl">
                <!-- Globe -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-pulse">
                    <svg class="w-48 h-48 text-[#a3b1e6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>

                <!-- Network connections -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <!-- Connection lines (animated) -->
                    <div class="relative w-64 h-64">
                        <!-- Horizontal line -->
                        <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-[#a3b1e6] animate-pulse"></div>
                        <!-- Vertical line -->
                        <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-[#a3b1e6] animate-pulse"></div>
                        <!-- Diagonal lines -->
                        <div class="absolute top-0 left-0 w-full h-full">
                            <div class="absolute top-0 left-0 w-full h-full border-t-2 border-l-2 border-[#a3b1e6] rounded-full animate-spin-slow"
                                style="border-right-color: transparent; border-bottom-color: transparent;"></div>
                            <div class="absolute top-0 left-0 w-full h-full border-t-2 border-r-2 border-[#a3b1e6] rounded-full animate-spin-slow-reverse"
                                style="border-left-color: transparent; border-bottom-color: transparent;"></div>
                        </div>
                    </div>
                </div>

                <!-- Connection nodes (circles) -->
                <div class="absolute top-1/4 left-1/4 w-6 h-6 rounded-full bg-[#5c6bb4] animate-bounce"></div>
                <div class="absolute top-1/4 right-1/4 w-6 h-6 rounded-full bg-[#5c6bb4] animate-bounce"
                    style="animation-delay: 0.2s;"></div>
                <div class="absolute bottom-1/4 left-1/4 w-6 h-6 rounded-full bg-[#5c6bb4] animate-bounce"
                    style="animation-delay: 0.4s;"></div>
                <div class="absolute bottom-1/4 right-1/4 w-6 h-6 rounded-full bg-[#5c6bb4] animate-bounce"
                    style="animation-delay: 0.6s;"></div>

                <!-- Floating people icons (connected to globe) -->
                <div class="absolute top-10 left-10 animate-float">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 rounded-full bg-green-400"></div>
                </div>

                <div class="absolute top-10 right-10 animate-float" style="animation-delay: 0.5s;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 rounded-full bg-green-400"></div>
                </div>

                <div class="absolute bottom-10 left-10 animate-float" style="animation-delay: 1s;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 rounded-full bg-green-400"></div>
                </div>

                <div class="absolute bottom-10 right-10 animate-float" style="animation-delay: 1.5s;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 rounded-full bg-green-400"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin-slow {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-slow-reverse {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }

        .animate-spin-slow-reverse {
            animation: spin-slow-reverse 10s linear infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    @if (session('success'))
        <script>
            // Store dismissal in localStorage if you want it to persist across page refreshes
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    const closeButton = alert.querySelector('button[type="button"]');
                    closeButton.addEventListener('click', function() {
                        // Optionally make an AJAX call to clear the session on server
                        fetch('/clear-success-session', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        });
                    });
                }
            });
        </script>
    @endif

</body>

</html>
