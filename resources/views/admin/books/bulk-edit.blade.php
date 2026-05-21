<x-app-layout>
    <div class="py-10">
        <div class="max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="font-bold text-3xl text-slate-800 tracking-tight">Bulk Edit Inventory</h2>
                    <p class="text-sm text-slate-500 mt-2">Edit multiple books at once. Changes are not saved until you
                        click update.</p>
                </div>
                <a href="{{ route('admin.books.index') }}"
                    class="inline-flex items-center px-4 py-2.5 border border-slate-300 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 transition">
                    &larr; Cancel
                </a>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl shadow-sm">
                    <p class="text-sm text-rose-800 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.books.bulk-update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Title
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Author
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Category
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">ISBN</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Cover
                                        Image</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase w-24">
                                        Total Qty</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($books as $index => $book)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <!-- Hidden ID -->
                                        <input type="hidden" name="books[{{ $index }}][id]" value="{{ $book->id }}">

                                        <!-- Title -->
                                        <td class="px-2 py-2">
                                            <input type="text" name="books[{{ $index }}][title]" value="{{ $book->title }}"
                                                required
                                                class="block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md bg-transparent hover:bg-white transition-colors">
                                        </td>

                                        <!-- Author Dropdown -->
                                        <td class="px-2 py-2">
                                            <select name="books[{{ $index }}][author_id]" required
                                                class="block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md bg-transparent hover:bg-white transition-colors">
                                                @foreach($authors as $author)
                                                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->author_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- Category Dropdown -->
                                        <td class="px-2 py-2">
                                            <select name="books[{{ $index }}][category_id]" required
                                                class="block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md bg-transparent hover:bg-white transition-colors">
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <!-- ISBN -->
                                        <td class="px-2 py-2">
                                            <input type="text" name="books[{{ $index }}][isbn]" value="{{ $book->isbn }}"
                                                required
                                                class="block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono rounded-md bg-transparent hover:bg-white transition-colors">
                                        </td>

                                        <td class="px-2 py-2 text-center align-middle">
                                            @if($book->cover_image && file_exists(public_path('storage/' . $book->cover_image)))
                                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                    class="w-8 h-10 object-cover mx-auto mb-1 rounded shadow-sm border border-slate-200"
                                                    alt="Cover">
                                            @endif
                                            <input type="file" name="books[{{ $index }}][cover]" accept="image/*"
                                                class="block w-full text-[10px] text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                        </td>

                                        <!-- Quantity -->
                                        <td class="px-2 py-2">
                                            <input type="number" min="1" name="books[{{ $index }}][quantity]"
                                                value="{{ $book->quantity }}" required
                                                class="block w-full border-transparent focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-indigo-700 rounded-md bg-indigo-50 hover:bg-white transition-colors">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer / Save Button -->
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end">
                        <button type="submit"
                            class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                            Save All Changes
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>