<x-guest-layout>
    <div class="py-14">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <x-card>
                <x-slot:content class="!py-8 sm:!px-10">
                    <div class="mb-6 text-sm text-gray-600">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <x-alert
                            class="mb-6"
                            type="success"
                            message="{{ __('A new verification link has been sent to the email address you provided during registration.') }}"
                        />
                    @endif

                    <div class="flex items-center justify-between mt-6">
                        <form
                            method="POST"
                            action="{{ route('verification.send') }}"
                        >
                            @csrf

                            <div>
                                <button class="w-full btn btn-primary">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </div>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="btn btn-link"
                            >
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </x-slot:content>
            </x-card>
        </div>
    </div>
</x-guest-layout>
