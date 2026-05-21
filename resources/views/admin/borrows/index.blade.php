<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="font-bold text-3xl text-slate-800 tracking-tight">Borrow & Return Management</h2>
                <p class="text-sm text-slate-500 mt-2">Approve requests, set due dates, and process returned books.</p>
            </div>
            
            @if(session('success'))
                <div class="mb-6 flex items-center bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Student</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Book Details</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Timeline</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    
                                    <!-- Student -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                {{ substr($transaction->user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900">{{ $transaction->user->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $transaction->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Book -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-800">{{ $transaction->book->title }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">ISBN: <span class="font-mono">{{ $transaction->book->isbn }}</span></div>
                                    </td>

                                    <!-- Timeline (Requested, Due, Returned) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600 font-medium space-y-1">
                                        <div><span class="text-slate-400">Req:</span> {{ $transaction->request_date ? $transaction->request_date->format('M d, Y') : 'N/A' }}</div>
                                        @if($transaction->status === 'Active')
                                            <div class="text-amber-600 font-bold"><span class="text-amber-400">Due:</span> {{ $transaction->due_date ? $transaction->due_date->format('M d, Y') : 'N/A' }}</div>
                                        @elseif($transaction->status === 'Returned')
                                            <div class="text-emerald-600"><span class="text-emerald-400">Ret:</span> {{ $transaction->return_date ? $transaction->return_date->format('M d, Y') : 'N/A' }}</div>
                                        @endif
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($transaction->approval_status === 'Pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">Awaiting Approval</span>
                                        @elseif($transaction->status === 'Active')
                                            @if($transaction->due_date && $transaction->due_date < now())
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-700 border border-rose-200 animate-pulse">Overdue</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 border border-amber-200">Borrowed (Active)</span>
                                            @endif
                                        @elseif($transaction->status === 'Returned')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 border border-emerald-200">Returned</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-100 text-rose-700 border border-rose-200">Rejected</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        
                                        <!-- If Pending: Show Approve (with Days input) and Reject -->
                                        @if($transaction->approval_status === 'Pending')
                                            <div class="flex justify-end items-center gap-2">
                                                <form method="POST" action="{{ route('admin.borrows.approve', $transaction->id) }}" class="flex items-center gap-2 bg-indigo-50 pl-3 pr-1 py-1 rounded-lg border border-indigo-100">
                                                    @csrf
                                                    <span class="text-xs font-bold text-indigo-800">Days:</span>
                                                    <input type="number" name="due_days" value="7" min="1" required class="w-16 h-7 text-xs border-slate-300 rounded focus:ring-indigo-500 focus:border-indigo-500 text-center font-bold text-slate-700">
                                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                                                        Approve
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.borrows.reject', $transaction->id) }}">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center justify-center px-3 py-2 border border-slate-300 text-xs font-bold rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm transition">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        
                                        <!-- If Active: Show Mark as Returned -->
                                        @elseif($transaction->status === 'Active')
                                            <form method="POST" action="{{ route('admin.borrows.return', $transaction->id) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-xs font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition transform hover:-translate-y-0.5">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Mark as Returned
                                                </button>
                                            </form>
                                        
                                        <!-- Else: Done -->
                                        @else
                                            <span class="text-slate-400 italic text-xs font-bold px-3">Completed</span>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">No requests found</h3>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>