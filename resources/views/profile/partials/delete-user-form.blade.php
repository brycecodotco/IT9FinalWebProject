<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-rose-600">Delete Account</h2>
        <p class="mt-1 text-sm text-rose-500/80">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex justify-center items-center px-6 py-3 border border-rose-200 text-sm font-bold rounded-xl shadow-sm text-rose-600 bg-white hover:bg-rose-50 focus:outline-none transition transform hover:-translate-y-0.5">
        Delete My Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-slate-800">Are you sure you want to delete your account?</h2>
            <p class="mt-2 text-sm text-slate-500">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

            <div class="mt-6">
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Password</label>
                <input id="password" name="password" type="password" class="block w-full border border-slate-300 rounded-xl shadow-sm px-4 py-3 text-slate-900 font-medium focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none transition bg-white" placeholder="Password" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center items-center px-4 py-2.5 border border-slate-300 text-sm font-bold rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition">
                    Cancel
                </button>

                <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-rose-600 hover:bg-rose-700 focus:outline-none transition">
                    Permanently Delete
                </button>
            </div>
        </form>
    </x-modal>
</section>