<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Vui lòng nhập mã OTP đã gửi đến email: ') }} <strong>{{ request('email') ?? $email }}</strong>
    </div>

    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify.process') }}">
        @csrf

        <!-- Email (Hidden) -->
        <input type="hidden" name="email" value="{{ request('email') ?? $email }}">

        <!-- OTP Code -->
        <div>
            <x-input-label for="otp" :value="__('Mã OTP (6 số)')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Xác nhận mã OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
