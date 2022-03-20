<x-app-layout>
    <div class="w-1/2 mx-auto mt-2">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="flex justify-between px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Account Details') }}
                </h3>
                @if (!$user->hasVerifiedEmail())
                    {{-- <form method="GET" action="{{ route('profile.admin.edit') }}">
                        @csrf
                        <div>
                            <x-button>
                                {{ __('Edit') }}
                            </x-button>
                        </div>
                    </form> --}}
                    <a href="{{ route('profile.admin.edit') }}">
                        <x-button type="button">
                            {{ __('Edit') }}
                        </x-button>
                    </a>
                @else
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-button>
                                {{ __('Resend Verification Email') }}
                            </x-button>
                        </div>
                    </form>
                @endif
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Full name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->name }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Role
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->roles()->pluck('name')[0] }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Email address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->email }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Phone Number
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $user->phone_number }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
