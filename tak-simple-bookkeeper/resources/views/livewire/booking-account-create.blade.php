<div>

    {{-- laten we leeg --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Settings voor nieuw account
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="">


            <form wire:submit.prevent="save">

                <div class="flex justify-center ">

                    <div wire:loading.class.remove="success-fader" wire:loading.class.remove="error-fader"
                        class="overflow-hidden rounded shadow-lg
            
                        @if (session()->has('message')) @if (session('message') === 'success')
                            success-fader @endif
                        @endif
                        @if (session()->has('message')) @if (session('message') === 'error')
                                error-fader @endif
                        @endif
                        ">


                        <div class="grid grid-cols-2 gap-4">

                            <div class="px-6 py-4">
                                <div class="mb-2">
                                    <label class="text-sm" for="account_name">Account naam</label><br />
                                    <input type="text" wire:model.lazy="name" placeholder="type.." required>
                                    @error('name')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    De naam van het account wordt gebruikt in de weergave van alle pagina's.
                                </p>
                            </div>



                            <div class="px-6 py-4">
                                <div class="mb-2">
                                    <label class="text-sm" for="account_named_id">Account keyname</label><br />
                                    <input type="text" wire:model.lazy="named_id" placeholder="type.." required>
                                    @error('named_id')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    Deze naam wordt intern gebruikt als account naam. Als je bank account bijvoorbeeld
                                    'NL12INGB1234567890' is dan
                                    kun je dat hier invullen. De boekingen worden dan ook opgeslagen met deze naam.
                                </p>
                            </div>


                        </div>



                        <div class="grid grid-cols-2 gap-4">

                            <div class="px-6 py-4">


                                <div class="mb-2">
                                    <label class="text-sm" for="account_slug">Account slug</label><br />
                                    <input type="text" wire:model.lazy="slug" placeholder="type.." required>
                                    @error('slug')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    De slug wordt gebruikt bij het aanroepen van de pagina, zie de adres balk in je
                                    browser.
                                    Die moet je dus alleen aanpassen als je weet wat je doet.
                                </p>
                            </div>


                            <div class="px-6 pt-4 pb-2">
                                <div>
                                    <label class="text-sm" for="account_slug">Start saldo</label><br />


                                    <input type="text" wire:model.lazy="start_balance" placeholder="0,00" required>
                                    @error('start_balance')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror


                                    <p class="mt-2 text-sm text-gray-700">
                                        Het begin saldo van dit
                                    </p>
                                </div>

                            </div>

                        </div>





                        <div class="grid grid-cols-2 gap-4">

                            <div class="px-6 py-4 form-row">
                                <label class="text-sm" for="account_polarity">Debet of Credit</label><br />
                                <div class="pl-4 form-group col-md-1">
                                    <input type="radio" checked wire:model="polarity" value="1">
                                    <label for="polarity">{{ __('debet account') }}</label>
                                </div>
                                <div class="pl-4 form-group col-md-1">

                                    <input type="radio" wire:model="polarity" value="-1">
                                    <label for="polarity">{{ __('credit account') }}</label>
                                </div>

                                <p class="mt-2 text-sm text-gray-700">
                                    Debet accounts zijn accounts waarop je geld binnen krijgt. <br />
                                    Credit accounts zijn accounts waarop je geld uitgeeft.
                                </p>
                            </div>

                        </div>


                        <div class="grid grid-cols-2 gap-4 px-6 py-4">

                            <div>
                                <x-button type="submit" class="justify-center w-48 mt-5">
                                    {{ __('Save') }}
                                </x-button>
                            </div>

                        </div>


                    </div>
                </div>
        </div>


        </form>





    </div>


</div>



</div>
