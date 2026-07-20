<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-8">
        <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-900">Welcome back</h2>
                <p class="mt-2 text-sm text-gray-500">Sign in to your account and continue reading.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <div class="relative">
                        <x-text-input id="password" class="block mt-1 w-full pr-20"
                                     type="password"
                                     name="password"
                                     required autocomplete="current-password" />

                        <label for="show_password_login" class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-500 hover:text-gray-700" title="Show password">
                            <input id="show_password_login" type="checkbox" class="sr-only" onchange="const input = document.getElementById('password'); input.type = this.checked ? 'text' : 'password'; this.parentElement.title = this.checked ? 'Hide password' : 'Show password'; this.parentElement.querySelector('svg').style.display = this.checked ? 'none' : 'block'; this.parentElement.querySelector('svg + svg').style.display = this.checked ? 'block' : 'none';">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.182a1.012 1.012 0 0 1 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.182Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-0.5 h-5 w-5" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.45 10.45 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65" />
                            </svg>
                        </label>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="mt-4 block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    @if (Route::has('register'))
                        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('register') }}">
                            {{ __('Register an account') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
