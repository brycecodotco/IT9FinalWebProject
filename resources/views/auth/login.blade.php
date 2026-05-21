<x-guest-layout>
    <!-- Alpine x-cloak style to prevent modal flashing -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="{ showModal: false }" class="p-8">

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4 shadow-inner">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
                    </path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-2 font-medium">Sign in to access the library catalog</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form Section -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username"
                        class="pl-10 block w-full rounded-xl border-gray-300 bg-gray-50 py-3 text-gray-900 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm"
                        placeholder="you@university.edu">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="pl-10 block w-full rounded-xl border-gray-300 bg-gray-50 py-3 text-gray-900 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm"
                        placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Login Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-all hover:-translate-y-0.5">
                    Sign In
                </button>
            </div>
        </form>

        <!-- Divider & Register Button -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-center text-sm text-gray-600 mb-4 font-medium">New to the library?</p>
            <button @click="showModal = true" type="button"
                class="w-full flex justify-center py-3 px-4 border-2 border-indigo-100 rounded-xl shadow-sm text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Create an Account
            </button>
        </div>

        <!-- ========================================= -->
        <!-- HIGH-END REGISTRATION MODAL (Alpine.js)   -->
        <!-- ========================================= -->
        <template x-teleport="body">

            <div x-show="showModal" x-cloak class="relative z-[999]" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">

                <!-- Modal Backdrop -->
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>

                <!-- Modal Content -->
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="showModal" @click.away="showModal = false"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                            <div class="bg-white px-6 pb-6 pt-8">
                                <div class="text-center w-full">
                                    <h3 class="text-2xl font-bold leading-6 text-gray-900 tracking-tight"
                                        id="modal-title">Join the Library</h3>
                                    <p class="text-sm text-gray-500 mt-2 mb-6">Select your role to access the
                                        appropriate dashboard.</p>

                                    <div class="grid grid-cols-1 gap-4 mt-4">
                                        <!-- Student Card Button -->
                                        <a href="{{ route('register', ['type' => 'student']) }}"
                                            class="group relative flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-gray-200 bg-white p-6 text-center hover:border-indigo-600 hover:bg-indigo-50 transition-all">
                                            <div
                                                class="p-3 bg-gray-100 rounded-full group-hover:bg-indigo-100 transition-colors">
                                                <svg class="w-8 h-8 text-gray-600 group-hover:text-indigo-600 transition-colors"
                                                    fill="none" stroke="currentColor" stroke-width="1.5"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-700">
                                                    Student Account</h4>
                                                <p class="text-xs text-gray-500 mt-1">Browse the catalog, request books,
                                                    and view your borrow history.</p>
                                            </div>
                                        </a>

                                        <!-- Employee Card Button -->
                                        <a href="{{ route('register', ['type' => 'employee']) }}"
                                            class="group relative flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-gray-200 bg-white p-6 text-center hover:border-blue-600 hover:bg-blue-50 transition-all">
                                            <div
                                                class="p-3 bg-gray-100 rounded-full group-hover:bg-blue-100 transition-colors">
                                                <svg class="w-8 h-8 text-gray-600 group-hover:text-blue-600 transition-colors"
                                                    fill="none" stroke="currentColor" stroke-width="1.5"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-700">
                                                    Employee / Admin</h4>
                                                <p class="text-xs text-gray-500 mt-1">Manage inventory, approve borrow
                                                    requests, and track returns.</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                                <button type="button" @click="showModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </template>
</x-guest-layout>