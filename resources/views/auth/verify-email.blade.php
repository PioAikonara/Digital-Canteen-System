<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Verifikasi Email</h1>
        <p class="text-gray-500 mt-2">Terima kasih sudah mendaftar! Cek email kamu dan klik link verifikasi yang kami kirimkan.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 font-medium">
            Link verifikasi baru telah dikirimkan ke email kamu.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition text-sm shadow-sm">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full px-6 py-3 border border-gray-300 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition text-sm">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
