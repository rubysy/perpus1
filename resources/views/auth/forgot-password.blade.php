<x-guest-layout>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed text-center">
        {{ __('Lupa password Anda? Tidak masalah. Beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset password agar Anda dapat membuat yang baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-sm" />
        </div>

        <div class="flex items-center justify-center mt-8">
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 font-semibold text-white transition-all bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-600/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 text-sm">
                Kirim Link Reset
            </button>
        </div>
    </form>
</x-guest-layout>
