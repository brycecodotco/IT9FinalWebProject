<x-app-layout>
    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h2 class="font-bold text-3xl text-slate-800 tracking-tight">My Borrowed Books</h2>
            <p class="text-sm text-slate-500 mt-2">Track your current reads, due dates, and past borrowing history.</p>
        </div>

        @if($transactions->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 text-center py-20 shadow-sm">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">No borrowing history</h3>
                <p class="text-slate-500 mt-2">You haven't requested any books yet.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block mt-6 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-sm hover:bg-indigo-700 transition">Browse Catalog</a>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Book</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Timeline</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50 transition">
                                <!-- Book Info with Mini Cover -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-16 bg-slate-100 rounded shadow-sm overflow-hidden flex-shrink-0 border-l-2 border-slate-800">
                                            @if($transaction->book->cover_image)
                                                <img src="{{ asset('storage/' . $transaction->book->cover_image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-indigo-600 flex items-center justify-center p-1 text-center">
                                                    <span class="text-[6px] font-bold text-white">{{ $transaction->book->title }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900">{{ $transaction->book->title }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">ISBN: {{ $transaction->book->isbn }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->approval_status === 'Pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <svg class="w-3 h-3 mr-1.5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Awaiting Approval
                                        </span>
                                    @elseif($transaction->status === 'Active')
                                        @if($transaction->due_date && $transaction->due_date < now())
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200 animate-pulse">OVERDUE</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">Borrowed (Active)</span>
                                        @endif
                                    @elseif($transaction->status === 'Returned')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Returned</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">Request Denied</span>
                                    @endif
                                </td>

                                <!-- Dates / Timeline -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs space-y-1.5 font-medium">
                                        <div class="text-slate-500">Requested: <span class="text-slate-800">{{ $transaction->request_date->format('M d, Y') }}</span></div>
                                        
                                        @if($transaction->status === 'Active')
                                            @if($transaction->due_date && $transaction->due_date < now())
                                                <div class="text-rose-600 font-bold">Was Due: {{ $transaction->due_date->format('M d, Y') }}</div>
                                            @else
                                                <div class="text-indigo-600 font-bold">Due Date: {{ $transaction->due_date ? $transaction->due_date->format('M d, Y') : 'Pending' }}</div>
                                            @endif
                                        @elseif($transaction->status === 'Returned')
                                            <div class="text-emerald-600">Returned on: {{ $transaction->return_date ? $transaction->return_date->format('M d, Y') : 'Unknown' }}</div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>