<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Bạn quên mật khẩu? Không sao cả. Chỉ cần nhập email, chúng tôi sẽ gửi mã OTP xác nhận để bạn tạo mật khẩu mới.') }}
    </div>

    @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.send') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Địa chỉ Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Gửi mã OTP') }} </x-primary-button>
        </div>
    </form>
</x-guest-layout>
