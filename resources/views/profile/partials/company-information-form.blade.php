<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Company Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('The settings for your comany are set in the .env file. You can not edit them here (yet).') }}
        </p>
    </header>
    <form class="mt-6 space-y-6">

        {{-- <form
        method="post"
        action="{{ route('profile.update') }}"
        class="mt-6 space-y-6"
    > --}}
        {{-- @csrf
        @method('patch') --}}

        {{-- <div class="space-y-2">
            <x-form.label for="name" :value="__('Name')" />

            <x-form.input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />

            <x-form.error :messages="$errors->get('name')" />
        </div> --}}

        <div class="space-y-2">
            <x-form.label for="name" :value="__('Name')" />

            <x-form.input disabled id="name" name="name" type="text" class="block w-full" :value="old('name', config('company.name'))"
                autofocus autocomplete="name" />

            <x-form.error :messages="$errors->get('name')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="address" :value="__('address')" />

            <x-form.input disabled id="address" name="address" type="text" class="block w-full" :value="old('address', config('company.address'))"
                autofocus autocomplete="address" />

            <x-form.error :messages="$errors->get('address')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="zip" :value="__('zip')" />

            <x-form.input disabled id="zip" name="zip" type="text" class="block w-full" :value="old('zip', config('company.zip'))"
                autofocus autocomplete="zip" />

            <x-form.error :messages="$errors->get('zip')" />
        </div>


        <div class="space-y-2">
            <x-form.label for="city" :value="__('city')" />

            <x-form.input disabled id="city" name="city" type="text" class="block w-full" :value="old('city', config('company.city'))"
                autofocus autocomplete="city" />

            <x-form.error :messages="$errors->get('city')" />
        </div>




        <div class="space-y-2">
            <x-form.label for="country" :value="__('country')" />

            <x-form.input disabled id="country" name="country" type="text" class="block w-full" :value="old('country', config('company.country'))"
                autofocus autocomplete="country" />

            <x-form.error :messages="$errors->get('country')" />
        </div>


        <div class="space-y-2">
            <x-form.label for="email" :value="__('email')" />

            <x-form.input disabled id="email" name="email" type="text" class="block w-full" :value="old('email', config('company.email'))"
                autofocus autocomplete="email" />

            <x-form.error :messages="$errors->get('email')" />
        </div>




        <div class="space-y-2">
            <x-form.label for="website" :value="__('website')" />

            <x-form.input disabled id="website" name="website" type="text" class="block w-full" :value="old('website', config('company.website'))"
                autofocus autocomplete="website" />

            <x-form.error :messages="$errors->get('website')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="phone" :value="__('phone')" />

            <x-form.input disabled id="phone" name="phone" type="text" class="block w-full" :value="old('phone', config('company.phone'))"
                autofocus autocomplete="phone" />

            <x-form.error :messages="$errors->get('phone')" />
        </div>


        <div class="space-y-2">
            <x-form.label for="bankaccount" :value="__('bankaccount')" />

            <x-form.input disabled id="bankaccount" name="bankaccount" type="text" class="block w-full"
                :value="old('bankaccount', config('company.bankaccount'))" autofocus autocomplete="bankaccount" />

            <x-form.error :messages="$errors->get('bankaccount')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="bankaccountname" :value="__('bankaccountname')" />

            <x-form.input disabled id="bankaccountname" name="bankaccountname" type="text" class="block w-full"
                :value="old('bankaccountname', config('company.bankaccountname'))" autofocus autocomplete="bankaccountname" />

            <x-form.error :messages="$errors->get('bankaccountname')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="kvknumber" :value="__('kvknumber')" />

            <x-form.input disabled id="kvknumber" name="kvknumber" type="text" class="block w-full"
                :value="old('kvknumber', config('company.kvknumber'))" autofocus autocomplete="kvknumber" />

            <x-form.error :messages="$errors->get('kvknumber')" />
        </div>



        <div class="space-y-2">
            <x-form.label for="vatnumber" :value="__(
                'Uw omzetbelastingnummer gebruikt u voor contact met de Belastingdienst. Bijvoorbeeld als u btw-aangifte doet of ons belt.',
            )" />

            <x-form.input disabled id="vatnumber" name="vatnumber" type="text" class="block w-full"
                :value="old('vatnumber', config('company.vatnumber'))" autofocus autocomplete="vatnumber" />

            <x-form.error :messages="$errors->get('vatnumber')" />
        </div>




        <div class="space-y-2">
            <x-form.label for="vatidnumber" :value="__(
                'Btw-identificatienummer. Uw btw-identificatienummer gebruikt u voor uw zakelijke contacten met klanten of leveranciers.',
            )" />

            <x-form.input disabled id="vatidnumber" name="vatidnumber" type="text" class="block w-full"
                :value="old('vatidnumber', config('company.vatidnumber'))" autofocus autocomplete="vatidnumber" />

            <x-form.error :messages="$errors->get('vatidnumber')" />
        </div>








        {{-- <div class="flex items-center gap-4">
            <x-button>
                {{ __('Save') }}
            </x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div> --}}
    </form>
</section>
