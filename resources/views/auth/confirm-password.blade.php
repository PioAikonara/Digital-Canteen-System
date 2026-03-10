<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Konfirmasi Password</h1>
        <p class="text-gray-500 mt-2">Ini adalah area aman. Masukkan password kamu untuk melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
                placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit"
            class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition text-sm shadow-sm">
            Konfirmasi →
        </button>
    </form>
</x-guest-layout>
