<nav x-data="{ open: false }"
    class="bg-white/90 backdrop-blur-lg border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">

            <!-- Left Side: Logo & Main Links -->
            <div class="flex items-center gap-8">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25">
                                </path>
                            </svg>
                        </div>
                        <span class="font-extrabold text-xl tracking-tight text-slate-800">IT9<span
                                class="text-indigo-600">Library</span></span>
                    </a>
                </div>

                <!-- Desktop Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-2">
                    @if(Auth::user()->role->role_name === 'Employee')
                        <!-- Employee Links -->
                        <a href="{{ route('admin.borrows.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.borrows.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Requests
                        </a>
                        <a href="{{ route('admin.books.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.books.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            Inventory
                        </a>
                        <a href="{{ route('admin.authors.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.authors.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Authors
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            Categories
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Users
                        </a>
                    @else
                        <!-- Student Links -->
                        <a href="{{ route('catalog.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('catalog.index') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Browse Catalog
                        </a>
                        <!-- My Books Link -->
                        <a href="{{ route('user.borrows') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('user.borrows') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            My Books
                        </a>
                        <!-- Cart Link with Badge -->
                        <a href="{{ route('cart.index') }}"
                            class="relative inline-flex items-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold transition-all {{ request()->routeIs('cart.index') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            My Cart
                            @if(count(session()->get('cart', [])) > 0)
                                <span
                                    class="absolute top-1.5 right-1.5 flex items-center justify-center min-w-[16px] h-4 px-1 text-[9px] font-extrabold text-white bg-rose-500 rounded-full shadow-sm">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Side: Profile & Mobile Toggle -->
            <div class="flex items-center gap-4">

                <!-- Desktop Profile Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false"
                        @close.stop="dropdownOpen = false">

                        <!-- Trigger Button -->
                        <div @click="dropdownOpen = ! dropdownOpen">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition shadow-sm cursor-pointer">
                                <div
                                    class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 z-50 mt-2 w-56 rounded-xl shadow-xl bg-white border border-slate-200 origin-top-right"
                            style="display: none;">

                            <!-- User Info Header -->
                            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50 rounded-t-xl">
                                <p class="text-sm font-extrabold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-slate-500 truncate mt-0.5">{{ Auth::user()->email }}
                                </p>
                            </div>

                            <!-- Profile Link -->
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                    Profile Settings
                                </a>
                            </div>

                            <!-- Log Out Link -->
                            <div class="py-1 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block px-5 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors rounded-b-xl">
                                        Log Out
                                    </a>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Hamburger (Mobile Menu Button) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none transition duration-150">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden bg-white border-t border-slate-200 shadow-lg absolute w-full">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role->role_name === 'Employee')
                <x-responsive-nav-link :href="route('admin.borrows.index')"
                    :active="request()->routeIs('admin.borrows.*')">Requests</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.books.index')"
                    :active="request()->routeIs('admin.books.*')">Inventory</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.authors.index')"
                    :active="request()->routeIs('admin.authors.*')">Authors</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.categories.index')"
                    :active="request()->routeIs('admin.categories.*')">Categories</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('catalog.index')" :active="request()->routeIs('catalog.index')">Browse
                    Catalog</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.borrows')" :active="request()->routeIs('user.borrows')">My
                    Books</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    My Books @if(count(session()->get('cart', [])) > 0) ({{ count(session('cart')) }}) @endif
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile Settings</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>