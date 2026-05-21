<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h2 class="font-bold text-3xl text-slate-800 tracking-tight">Profile Settings</h2>
                <p class="text-sm text-slate-500 mt-2">Manage your account information, password, and security.</p>
            </div>

            <!-- Profile Info Card -->
            <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-slate-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="p-6 sm:p-8 bg-rose-50/50 shadow-sm sm:rounded-2xl border border-rose-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>