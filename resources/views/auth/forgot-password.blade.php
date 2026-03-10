<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Lupa Password?</h1>
        <p class="text-gray-500 mt-2">Masukkan email kamu dan kami akan kirimkan link reset password.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
                placeholder="contoh@email.com" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit"
            class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition text-sm shadow-sm">
            Kirim Link Reset →
        </button>

        <p class="text-center text-sm text-gray-500">
            Sudah ingat password?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-800">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
