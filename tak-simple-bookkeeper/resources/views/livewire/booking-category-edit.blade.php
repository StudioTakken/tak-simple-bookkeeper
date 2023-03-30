<div>

    {{-- laten we leeg --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Settings voor categorie: {{ $category->name }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="">


            <form wire:submit.prevent="save">

                <div class="flex justify-center ">
                    <div
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
                                    <label class="text-sm" for="category_name">Categorie naam</label><br />
                                    <input type="text" wire:model.debounce.4s="category.name" placeholder="type.."
                                        required>
                                    @error('category.name')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    De naam van de categorie wordt gebruikt in de weergave van alle pagina's.
                                </p>
                            </div>



                            <div class="px-6 py-4">
                                <div class="mb-2">
                                    <label class="text-sm" for="category_named_id">Categorie keyname</label><br />
                                    <input type="text" wire:model.debounce.4s="category.named_id"
                                        placeholder="type.." required>
                                    @error('category.named_id')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <p class="text-sm text-gray-700">
                                    Deze naam wordt intern gebruikt als categorie naam. Deze moet uniek zijn.
                                </p>
                            </div>


                        </div>






                        <div class="grid grid-cols-2 gap-4">



                            <div class="px-6 py-4">
                                <div class="mb-2">
                                    <label class="text-sm" for="category_slug">Categorie slug</label><br />
                                    <input type="text" wire:model.debounce.4s="category.slug" placeholder="type.."
                                        required>
                                    @error('category.slug')
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



                            <div class="px-6 py-4 ">
                                <div class="mb-2">
                                    <label class="text-sm" for="opmerkingen">Opmerkingen</label><br />
                                    <textarea class="w-full text-sm" wire:model.debounce.4s="category.remarks" placeholder="type.."></textarea>

                                </div>
                                <p class="text-sm text-gray-700">
                                    Opmerkingen
                                </p>
                            </div>

                        </div>


                        <div class="grid grid-cols-3 gap-4">




                            <div class="px-6 py-4 my-5">

                                <label class="text-sm" for="opmerkingen">Debet of Credit</label><br />
                                <div class="form-row">
                                    <div class="pl-4 form-group col-md-1">
                                        <input type="radio" checked wire:model="category.polarity" value="1">
                                        <label for="polarity">{{ __('debet categorie') }}</label>
                                    </div>
                                    <div class="pl-4 form-group col-md-1">

                                        <input type="radio" wire:model="category.polarity" value="-1">
                                        <label for="polarity">{{ __('credit categorie') }}</label>
                                    </div>

                                    @error('category.polarity')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-700">
                                        Debet categorieën zijn categorieën waarop je geld binnen krijgt. <br />
                                        Credit categorieën zijn categorieën waarop je geld uitgeeft.
                                    </p>
                                </div>

                            </div>


                            <div class="px-6 py-4 my-5">

                                <label class="text-sm" for="opmerkingen">Weergeven in Winst en Verlies</label><br />
                                <div class="form-row">
                                    <div class="pl-4 form-group col-md-1">
                                        <input type="radio" checked wire:model="category.loss_and_provit"
                                            value="1">
                                        <label for="loss_and_provit">{{ __('Ja') }}</label>
                                    </div>
                                    <div class="pl-4 form-group col-md-1">

                                        <input type="radio" wire:model="category.loss_and_provit" value="0">
                                        <label for="loss_and_provit">{{ __('Nee') }}</label>
                                    </div>
                                    @error('category.loss_and_provit')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-700">
                                        Is dit een categorie die invloed heeft op de winst en verlies?
                                    </p>
                                </div>

                            </div>



                            <div class="px-6 py-4 my-5">

                                <label class="text-sm" for="opmerkingen">Weergeven in BTW overzicht</label><br />
                                <div class="form-row">
                                    <div class="pl-4 form-group col-md-1">
                                        <input type="radio" checked wire:model="category.vat_overview" value="1">
                                        <label for="vat_overview">{{ __('Ja') }}</label>
                                    </div>
                                    <div class="pl-4 form-group col-md-1">

                                        <input type="radio" wire:model="category.vat_overview" value="0">
                                        <label for="vat_overview">{{ __('Nee') }}</label>
                                    </div>
                                    @error('category.vat_overview')
                                        <br />
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-700">
                                        Is dit een categorie die invloed heeft op de btw?
                                    </p>
                                </div>

                            </div>






                        </div>



                        <div class="grid grid-cols-2 gap-4 px-6 py-4">

                            <div>
                                <x-button type="submit" class="justify-center w-48 mt-5">
                                    {{ __('Save') }}
                                </x-button>
                            </div>



                            @if (isset($category))
                                <div class="mt-5">
                                    <button class="settingsbutton soft">
                                        <a href="{{ route('category.oncategory', $category->slug) }}">
                                            Terug naar {{ $category->name }}
                                        </a>
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
        </div>


        </form>



        @if ($nr_of_bookings_in_category < 1)

            <div class='p-6 text-sm'>


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
                                                    id="modal-title">Verwijder categorie</h3>
                                                <div class="mt-2">

                                                    <i>
                                                        {{ $category->name }}<br />

                                                    </i>

                                                    <br />

                                                    <p class="text-sm text-gray-500">Weet je zeker dat deze categorie
                                                        moet worden verwijderd? Dit kan niet ongedaan worden gemaakt.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 sm:flex sm:flex-row-reverse sm:px-6">





                                        <button type="button" wire:click="removeCategory"
                                            class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-red-600 rounded-md shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Verwijder</button>
                                        <button type="button" wire:click="removeCategoryCancel"
                                            class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <tr class=''>
                        <button class="settingsbutton" wire:click="showDeleteConfirm"><i class="fa fas fa-ban"
                                aria-hidden="true"></i> Verwijderen</button>

                @endif

            </div>
        @else
            <div class='p-6 text-sm'>
                @if ($nr_of_bookings_in_category > 0)
                    You can not delete this category because there are {{ $nr_of_bookings_in_category }} bookings in
                    this
                    category.
                @endif

            </div>
        @endif






    </div>


</div>



</div>
