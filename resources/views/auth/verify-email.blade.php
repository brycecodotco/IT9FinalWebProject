<x-guest-layout>
    <div class="p-8 text-center">
        
        <!-- Mail Icon Graphic -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-50 mb-6 shadow-inner relative">
            <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path>
            </svg>
            <!-- Little notification dot -->
            <span class="absolute top-1 right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-blue-500 border-2 border-white"></span>
            </span>
        </div>

        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-3">Check your inbox</h2>
        
        <p class="text-sm text-gray-600 leading-relaxed mb-6">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </p>

        <!-- Status Message if Link is Resent -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 rounded-lg bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            A new verification link has been sent to your email address.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-4 flex flex-col items-center justify-center space-y-4 border-t border-gray-100 pt-6">
            
            <!-- Resend Email Form -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Resend Verification Email
                </button>
            </form>

            <!-- Logout Form (Secondary Action) -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-500 hover:text-gray-900 underline transition-colors">
                    Log Out
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>