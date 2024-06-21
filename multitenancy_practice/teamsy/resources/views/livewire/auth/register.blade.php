<div class="flex flex-col justify-center min-h-screen py-12 bg-gray-50 sm:px-6 lg:px-8">
    <x-navigation/>
    <div>
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
                Start a free trial
            </h2>

            <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
                Or
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    sign in to your account
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
                <form wire:submit.prevent="register">
                    <x-text-input
                        wire:model.lazy="name"
                        type="text"
                        label="Name"
                        :required="true"
                        placeholder="Your name here"
                        class="mt-6"
                    />

                    <x-text-input
                        wire:model.lazy="companyName"
                        type="text"
                        label="Company Name"
                        :required="true"
                        placeholder="Your company's name here"
                        class="mt-6"
                    />

                    <x-text-input
                        wire:model.lazy="email"
                        type="text"
                        label="Email"
                        :required="true"
                        placeholder="Your email here"
                        class="mt-6"
                    />

                    <x-text-input
                        wire:model.lazy="password"
                        type="password"
                        label="Password"
                        :required="true"
                        placeholder="Your password here"
                        class="mt-6"
                    />

                    <x-text-input
                        wire:model.lazy="passwordConfirmation"
                        type="password"
                        label="Confirm Password"
                        :required="true"
                        placeholder="Type your password again"
                        class="mt-6"
                    />

                    <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit" class="flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                    Register
                                </button>
                            </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
