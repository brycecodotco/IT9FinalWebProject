<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="font-bold text-3xl text-slate-800 tracking-tight">Manage Categories</h2>
                <p class="text-sm text-slate-500 mt-2">Organize your library by adding or managing book categories.</p>
            </div>

            <!-- Alerts -->
            @if(session('success')) <div class="mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-xl shadow-sm font-medium border border-emerald-200">{{ session('success') }}</div> @endif
            @if(session('error')) <div class="mb-6 bg-rose-50 text-rose-700 px-4 py-3 rounded-xl shadow-sm font-medium border border-rose-200">{{ session('error') }}</div> @endif
            @if($errors->any()) <div class="mb-6 bg-rose-50 text-rose-700 px-4 py-3 rounded-xl shadow-sm font-medium border border-rose-200">{{ $errors->first() }}</div> @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-28">
                        <h3 class="font-bold text-lg text-slate-800 mb-4">Add New Category</h3>
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Category Name</label>
                                <input type="text" name="category_name" required class="w-full border-slate-300 rounded-xl shadow-sm px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">Add Category</button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Category Name</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Total Books</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $category->category_name }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-slate-600">
                                        <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-full text-xs font-bold">{{ $category->books_count }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-rose-600 hover:text-rose-900 bg-rose-50 px-3 py-1.5 rounded-lg transition">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-8 text-center text-slate-500">No categories found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>