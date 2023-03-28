<div>

    {{-- laten we leeg --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Settings voor {{ $account->name }}
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
                                    <input type="text" wire:model.debounce.4s="account.name" placeholder="type.."
                                        required>
                                    @error('account.name')
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
                                    <input type="text" wire:model.debounce.4s="account.named_id" placeholder="type.."
                                        required>
                                    @error('account.named_id')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    Deze naam wordt intern gebruikt als account naam. Als je bank account bijvoorbeeld
                                    'NL94INGB0007001049' is dan
                                    kun je dat hier invullen. De boekingen worden dan ook opgeslagen met deze naam.
                                </p>
                            </div>


                        </div>



                        <div class="grid grid-cols-2 gap-4">

                            <div class="px-6 py-4">
                                <div class="mb-2">
                                    <label class="text-sm" for="account_slug">Account slug</label><br />
                                    <input type="text" wire:model.debounce.4s="account.slug" placeholder="type.."
                                        required>
                                    @error('account.slug')
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
                                    <input type="text" wire:model.debounce.4s="account.start_balance" class="w-100"
                                        class="numberinputfield" />
                                    @error('account.start_balance')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror


                                    <p class="mt-2 text-sm text-gray-700">
                                        Het begin saldo van dit account.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="grid grid-cols-2 gap-4">

                            <div class="px-6 py-4 form-row">
                                <label class="text-sm" for="account_plus_min_int">Debet of Credit</label><br />
                                <div class="pl-4 form-group col-md-1">
                                    <input type="radio" checked wire:model="account.plus_min_int" value="1">
                                    <label for="plus_min_int">{{ __('debet account') }}</label>
                                </div>
                                <div class="pl-4 form-group col-md-1">

                                    <input type="radio" wire:model="account.plus_min_int" value="-1">
                                    <label for="plus_min_int">{{ __('credit account') }}</label>
                                </div>

                                <p class="mt-2 text-sm text-gray-700">
                                    Debet accounts zijn accounts waarop je geld binnen krijgt. <br />
                                    Credit accounts zijn accounts waarop je geld uitgeeft.
                                </p>
                            </div>





                            <div>
                                <div class="flex justify-end px-6 py-4 mb-3">

                                    @if ($account->plus_min_int == 1)
                                        <div class="text-white btn bg-takgreen-500 btn-big"><i class="fa fas fa-plus "
                                                aria-hidden="true"></i>
                                        </div>
                                    @else
                                        <div class="text-white btn bg-takred-500 btn-big"><i class="fa fas fa-minus "
                                                aria-hidden="true"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="grid grid-cols-2 gap-4 px-6 py-4">


                            <div>
                                <x-button type="submit" class="justify-center w-48 mt-5">
                                    {{ __('Save') }}
                                </x-button>
                            </div>



                            @if (isset($account))
                                <div class="mt-5">
                                    <button
                                        class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
                                        <a href="{{ route('account.onaccount', $account->slug) }}">
                                            Terug naar {{ $account->name }}
                                        </a>
                                    </button>
                                </div>
                            @endif

                        </div>


                    </div>
                </div>
        </div>


        </form>





    </div>


</div>



</div>
