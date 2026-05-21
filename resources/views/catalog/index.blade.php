<x-app-layout>
    
    <!-- Stunning Hero Section -->
    <div class="bg-indigo-900 relative overflow-hidden pb-32 pt-16">
        <div class="absolute inset-0 opacity-20">
            <svg class="absolute left-0 top-0 h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon fill="currentColor" class="text-indigo-800" points="0,100 100,0 100,100"/></svg>
            <circle cx="85%" cy="20%" r="20%" fill="currentColor" class="text-blue-500 blur-3xl opacity-50"></circle>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
                Explore the <span class="text-indigo-300">Library Catalog</span>
            </h1>
            <p class="text-lg text-indigo-200 max-w-2xl mx-auto font-medium">
                Discover thousands of books, request to borrow, and expand your knowledge.
            </p>
        </div>
    </div>

    <!-- Search & Content Section -->
    <div class="-mt-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 relative z-10">
        
        <!-- UPGRADED Floating Filter Bar -->
        <form method="GET" action="{{ route('catalog.index') }}" class="bg-white/95 backdrop-blur-xl p-3 rounded-2xl shadow-2xl border border-white flex flex-col md:flex-row gap-3 max-w-5xl mx-auto mb-12">
            
            <!-- Search Text Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." class="w-full pl-11 bg-transparent border-none text-slate-900 focus:ring-0 font-medium placeholder-slate-400 py-3">
            </div>

            <div class="hidden md:block w-px bg-slate-200 my-2"></div>

            <!-- Category Filter -->
            <div class="flex-1 md:max-w-[200px]">
                <select name="category" class="w-full bg-transparent border-none text-slate-700 font-medium focus:ring-0 py-3 cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="hidden md:block w-px bg-slate-200 my-2"></div>

            <!-- Author Filter -->
            <div class="flex-1 md:max-w-[200px]">
                <select name="author" class="w-full bg-transparent border-none text-slate-700 font-medium focus:ring-0 py-3 cursor-pointer">
                    <option value="">All Authors</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                            {{ $author->author_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold shadow-md transition-all transform hover:-translate-y-0.5">Filter</button>
            
            @if(request()->hasAny(['search', 'category', 'author']))
                <a href="{{ route('catalog.index') }}" class="flex items-center justify-center px-4 text-slate-400 hover:text-rose-500 transition-colors" title="Clear Filters">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-8 max-w-5xl mx-auto flex items-center bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Book Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($books as $book)
                <div class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col">
                    
                    <div class="h-64 bg-slate-100 flex items-center justify-center p-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-100 opacity-50"></div>
                        
                        @if($book->cover_image)
                            <div class="w-36 h-52 rounded-r-md shadow-2xl border-l-8 border-slate-800 relative z-10 transform group-hover:scale-105 group-hover:-translate-y-2 transition-all duration-500 overflow-hidden bg-white flex-shrink-0">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/20 via-white/10 to-transparent pointer-events-none z-20"></div>
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" class="w-full h-full object-cover relative z-10">
                            </div>
                        @else
                            <div class="w-36 h-52 bg-white rounded-r-md shadow-2xl border-l-8 border-indigo-600 flex flex-col justify-center p-4 text-center relative z-10 transform group-hover:scale-105 group-hover:-translate-y-2 transition-all duration-500 flex-shrink-0">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/10 via-white/10 to-transparent pointer-events-none z-20"></div>
                                <!-- FIXED FALLBACK TEXT -->
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ $book->category->category_name }}</span>
                                <h4 class="text-sm font-extrabold text-slate-800 leading-tight line-clamp-4">{{ $book->title }}</h4>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-5 flex-1 flex flex-col bg-white">
                        <!-- FIXED TEXT OUTPUTS -->
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{ $book->category->category_name }}</span>
                        <h3 class="font-bold text-slate-900 mt-1 text-lg leading-tight">{{ $book->title }}</h3>
                        
                        <!-- HERE IS THE MISSING AUTHOR FIX -->
                        <p class="text-sm font-medium text-slate-500 mt-1 mb-4">{{ $book->author->author_name }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            @if($book->available_copies > 0)
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-emerald-600 uppercase">{{ $book->available_copies }} Copies Left</span>
                                </div>
                                
                                @if(in_array($book->id, session()->get('cart', [])))
                                    <a href="{{ route('cart.index') }}" class="text-sm font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-4 py-2.5 rounded-xl transition">In Cart &rarr;</a>
                                @else
                                    <form method="POST" action="{{ route('cart.add', $book->id) }}">
                                        @csrf
                                        <button type="submit" class="text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2.5 rounded-xl shadow-sm transform hover:-translate-y-0.5 transition">Add to Cart</button>
                                    </form>
                                @endif
                            @else
                                <span class="text-xs font-bold text-rose-600 uppercase">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 text-center py-20 shadow-sm mt-8">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">No books found</h3>
                    <p class="text-slate-500 mt-2">Try adjusting your filters or search terms.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>