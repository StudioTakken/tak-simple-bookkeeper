<div
    class="
@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif
">

    {{--  a div the aligns on the right side --}}

    <table class="w-full align-top border border-collapse border-slate-400">

        <tbody>

            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Description</td>
                <td class="px-2 align-top border border-slate-300">
                    <textarea wire:model.debounce.4s="description" wire:change="updateDescription" class="descriptioninputfield"
                        placeholder="type.." rows="4" required></textarea>
                </td>
            </tr>


            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Bedrag</td>
                <td class="px-2 font-bold align-top border border-slate-300">
                    {{ $amount }}
                </td>
            </tr>
            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Polarity</td>
                <td class="px-2 font-bold align-top border border-slate-300">




                    <div class="pl-4 form-group col-md-1">
                        <input type="radio" wire:model="polarity" wire:change="updatePolarity" value="1">
                        <label for="polarity">{{ __('plus +') }}</label>
                    </div>
                    <div class="pl-4 form-group col-md-1">

                        <input type="radio" wire:model="polarity" wire:change="updatePolarity" value="-1">
                        <label for="polarity">{{ __('min -') }}</label>
                    </div>

                </td>
            </tr>

            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Datum</td>
                <td class="px-2 align-top border border-slate-300">
                    <input class="py-0 text-sm border-gray-400" type="date" wire:model.debounce.2s="date"
                        id="date" name="date" wire:change.debounce.2s="updateDate">
                </td>
            </tr>


            @if ($booking->parent_id)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Parent booking</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->parent_id }}
                    </td>
                </tr>
            @endif

            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Invoice Nr</td>
                <td class="px-2 align-top border border-slate-300">

                    <input type="text" wire:model.debounce.4s="invoice_nr" wire:change="updateInvoiceNr"
                        class="descriptioninputfield" placeholder="type.."></textarea>
                </td>
            </tr>

            @if ($booking->bank_code)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Bank code</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->bank_code }}
                    </td>
                </tr>
            @endif
            @if ($booking->bank_code)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Bank code</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->bank_code }}
                    </td>
                </tr>
            @endif
            @if ($booking->tag)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Tag</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->tag }}
                    </td>
                </tr>
            @endif

            @if ($booking->mutation_type)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Mutation type</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->mutation_type }}
                    </td>
                </tr>
            @endif



            {{-- @if ($booking->remarks) --}}


            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">Remarks</td>
                <td class="px-2 align-top border border-slate-300">
                    <textarea wire:model.debounce.4s="remarks" wire:change="updateRemarks" class="h-64 descriptioninputfield"
                        placeholder="type.." rows="4" required></textarea>
                </td>
            </tr>

            {{-- @endif --}}




            @if ($booking->contra_account)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Tegenrekening</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->contra_account }}
                    </td>
                </tr>
            @endif




            {{-- @if ($booking->category != 'btw') --}}
            <tr class=''>
                <td class="px-2 text-sm align-top border border-slate-300">btw </td>
                <td class="px-2 align-top border border-slate-300">
                    <button class="btn btn-red btn-small" wire:click="splitBookingBtw"><i class="fa fa-share-alt"
                            aria-hidden="true"></i> btw 21%
                        uitsplitsen</button>
                </td>
            </tr>
            <tr class=''>
                <td class="px-2 align-top border border-slate-300"> <input class="text-right numberinputfield"
                        type="text" wire:model="splitOffAmount" placeholder="00,00" /> </td>
                <td class="px-2 align-top border border-slate-300">


                    <button class="btn btn-red btn-small" wire:click="splitOffAction"><i class="fa fa-share-alt"
                            aria-hidden="true"></i>
                        Uitsplitsen</button>
                </td>
            </tr>

            {{-- @endif --}}
            {{--  --}}


            @if ($booking->originals)
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Reset</td>
                    <td class="px-2 align-top border border-slate-300">
                        <button class="btn btn-red btn-small" wire:click="resetBooking"><i class="fa fa-reply"
                                aria-hidden="true"></i> Terug naar origineel </button>
                    </td>
                </tr>
            @endif



            @if ($delete_confirm)
                <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">

                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">

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
                                                id="modal-title">Verwijder boeking</h3>
                                            <div class="mt-2">

                                                <i>
                                                    {{ $booking->description }}<br />
                                                    {{ $amount }}
                                                </i><br />
                                                <p class="text-sm text-gray-500">Weet je zeker dat deze boeking moet
                                                    worden verwijderd? Kan niet ongedaan worden gemaakt.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button" wire:click="removeBooking"
                                        class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Verwijder</button>
                                    <button type="button" wire:click="removeBookingCancel"
                                        class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <tr class=''>
                    <td class="px-2 text-sm align-top border border-slate-300">Verwijderen</td>
                    <td class="px-2 align-top border border-slate-300">
                        <button class="btn btn-red btn-small" wire:click="showDeleteConfirm"><i class="fa fas fa-ban"
                                aria-hidden="true"></i> Verwijderen</button>
                    </td>
                </tr>
            @endif



        </tbody>
    </table>

    <br />


    @if (count($booking->booking_proves) > 0)
        <div class="my-5">

            <h3 class="font-bold">Bestanden</h3>
            @foreach ($booking->booking_proves as $prove)
                <button type="button" wire:click="removeProve({{ $prove->id }})">[x]</button>
                <a class="text-takred-500" href="{{ route('bookings.prove-download', $prove->id) }}"
                    class="btn btn-primary">
                    {{ $prove->name }}</a><br />
            @endforeach

        </div>

    @endif



    @if ($open_dropzone)
        @livewire ('dropzone-prove', ['booking' => $booking])
    @else
        <button class="settingsbutton" wire:click="openDropzone">Voeg bestanden toe</button>
    @endif

</div>
