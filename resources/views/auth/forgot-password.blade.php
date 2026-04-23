<x-guest-layout>
    <div class="my-4 max-w-xl mx-auto text-center text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-[95%] mx-auto md:max-w-100 bg-white px-6 py-4 sm:rounded-lg shadow-md">


        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Lien de réinitialisation du mot de passe') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>