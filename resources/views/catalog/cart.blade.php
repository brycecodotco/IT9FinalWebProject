<x-app-layout>
    <div class="py-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="font-bold text-3xl text-slate-800 tracking-tight">Your Borrow Cart</h2>
                <p class="text-sm text-slate-500 mt-2">Review your books before submitting the final request.</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-indigo-600 font-bold hover:underline">Continue Browsing
                &rarr;</a>
        </div>

        @if($books->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 text-center py-20 shadow-sm">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-xl font-bold text-slate-900">Your cart is empty</h3>
                <p class="text-slate-500 mt-2">Go to the catalog to find books you want to borrow.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <ul class="divide-y divide-slate-200">
                    @foreach($books as $book)
                        <li class="p-6 flex items-center justify-between hover:bg-slate-50">
                            <div class="flex items-center gap-6">
                                <!-- Mini 3D Book in Cart -->
                                <div
                                    class="w-16 h-24 bg-white rounded-r shadow-md border-l-4 border-slate-800 relative overflow-hidden flex-shrink-0">
                                    <!-- Miniature Lighting Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-black/20 via-transparent to-transparent pointer-events-none z-20">
                                    </div>

                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                            class="w-full h-full object-cover relative z-10">
                                    @else
                                        <!-- Mini Text Fallback -->
                                        <div
                                            class="w-full h-full bg-indigo-600 flex items-center justify-center p-1 text-center relative z-10">
                                            <span
                                                class="text-[8px] font-bold text-white leading-tight line-clamp-3">{{ $book->title }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">{{ $book->title }}</h4>
                                    <p class="text-sm text-slate-500">{{ $book->author->author_name }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('cart.remove', $book->id) }}">
                                @csrf
                                <button type="submit"
                                    class="text-rose-500 hover:text-rose-700 font-bold bg-rose-50 px-4 py-2 rounded-lg">Remove</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <div class="p-6 bg-slate-50 border-t border-slate-200 flex justify-between items-center">
                    <span class="text-slate-600 font-bold">Total Books: {{ count($books) }}</span>
                    <form method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition">Submit
                            Borrow Request</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>