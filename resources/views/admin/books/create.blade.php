<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 text-sm text-rose-700 font-medium">
                            Please check your inputs. One or more ISBNs may already exist.
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data"
                x-data="{ rows: [{title: '', author_id: '', category_id: '', isbn: '', quantity: 1}] }">
                @csrf
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                    <!-- Dynamic Rows Area -->
                    <div class="p-6 space-y-6 bg-slate-50">
                        <template x-for="(row, index) in rows" :key="index">
                            <div
                                class="relative grid grid-cols-1 md:grid-cols-12 gap-6 bg-white p-6 rounded-xl shadow-sm border border-slate-200 items-start">

                                <!-- Row Number Badge -->
                                <div class="absolute -top-3 -left-3 bg-indigo-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm"
                                    x-text="'Book ' + (index + 1)"></div>

                                <div class="col-span-1 md:col-span-3">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Book
                                        Title</label>
                                    <input type="text" x-model="row.title" :name="`books[${index}][title]`" required
                                        class="block w-full border border-slate-300 rounded-lg shadow-sm px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                        placeholder="e.g. The Great Gatsby">
                                </div>
                                <div class="col-span-1 md:col-span-3">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Author</label>
                                    <select x-model="row.author_id" :name="`books[${index}][author_id]`" required
                                        class="block w-full border border-slate-300 rounded-xl shadow-sm px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                                        <option value="" disabled selected>Select Author...</option>
                                        @foreach($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->author_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-1 md:col-span-3">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Category</label>
                                    <select x-model="row.category_id" :name="`books[${index}][category_id]`" required
                                        class="block w-full border border-slate-300 rounded-xl shadow-sm px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                                        <option value="" disabled selected>Select Category...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">ISBN</label>
                                    <input type="text" x-model="row.isbn" :name="`books[${index}][isbn]`" required
                                        class="block w-full border border-slate-300 rounded-lg shadow-sm px-4 py-2.5 text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                        placeholder="13-digit ISBN">
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Quantity</label>
                                    <input type="number" min="1" x-model="row.quantity"
                                        :name="`books[${index}][quantity]`" required
                                        class="block w-full border border-slate-300 rounded-xl shadow-sm px-4 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                </div>

                                <div class="col-span-1 md:col-span-3">
                                    <label
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Cover
                                        Image</label>
                                    <input type="file" accept="image/*" :name="`books[${index}][cover]`"
                                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                </div>

                                <div class="col-span-1 md:col-span-1 flex h-full items-end pb-1">
                                    <button type="button" @click="rows.splice(index, 1)" x-show="rows.length > 1"
                                        class="w-full inline-flex justify-center items-center px-3 py-2.5 border border-rose-200 text-sm font-medium rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Action Footer -->
                    <div
                        class="bg-white px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <button type="button"
                            @click="rows.push({title: '', author_name: '', category_name: '', isbn: ''})"
                            class="inline-flex items-center text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Another Row
                        </button>
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-bold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Save Inventory to Database
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>