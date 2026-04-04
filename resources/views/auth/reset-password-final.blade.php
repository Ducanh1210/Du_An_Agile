<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Mã OTP chính xác. Vui lòng thiết lập mật khẩu mới cho tài khoản: ') }} <strong>{{ $email }}</strong>
    </div>

    <form method="POST" action="{{ route('password.update.final') }}">
        @csrf

        <!-- Email & OTP (Hidden) -->
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="otp" value="{{ $otp }}">

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu mới')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu mới')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Đổi mật khẩu') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
