<div>

    {{-- laten we leeg --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Settings voor account {{ $account->name }}
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

                            </div>

                        </div>

                        <div class="grid grid-cols-2 gap-4 px-6 py-4">


                            <div>
                                <x-button type="submit" class="justify-center w-48 mt-5 text-white bg-takgreen-600">
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



        @if ($nr_of_bookings_in_account < 1 and $nr_of_cross_bookings_in_account < 1)

            <div class='p-6 text-sm'>

                {{ $delete_confirm }}

                @if ($delete_confirm)
                    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div
                                class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

                                <div
                                    class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg">
                                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-base font-semibold leading-6 text-gray-900"
                                                    id="modal-title">Verwijder account</h3>
                                                <div class="mt-2">

                                                    <i>
                                                        {{ $account->name }}<br />

                                                    </i><br />
                                                    <p class="text-sm text-gray-500">Weet je zeker dat dit account
                                                        moet worden verwijderd? Kan niet ongedaan worden gemaakt.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button type="button" wire:click="removeAccount"
                                            class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Verwijder</button>
                                        <button type="button" wire:click="removeAccountCancel"
                                            class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <tr class=''>


                        <button class="btn btn-red btn-small" wire:click="showDeleteConfirm"><i class="fa fas fa-ban"
                                aria-hidden="true"></i> Verwijderen</button>

                @endif





            </div>
        @else
            <div class='p-6 text-sm'>
                @if ($nr_of_bookings_in_account > 0)
                    You can not delete this account because there are {{ $nr_of_bookings_in_account }} bookings in this
                    account.
                @endif
                <br />
                @if ($nr_of_cross_bookings_in_account > 0)
                    You can not delete this account because there are {{ $nr_of_cross_bookings_in_account }} cross
                    bookings.
                @endif
            </div>
        @endif





    </div>


</div>



</div>
