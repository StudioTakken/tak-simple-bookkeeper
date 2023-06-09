<div>

    {{-- laten we leeg --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Settings voor nieuwe categorie
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
                                    <input type="text" wire:model.lazy="name" placeholder="type.." required>
                                    @error('name')
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
                                    <input type="text" wire:model.lazy="named_id" placeholder="type.." required>
                                    @error('named_id')
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



                            <div class="px-6 py-4 ">
                                <div class="mb-2">
                                    <label class="text-sm" for="opmerkingen">Opmerkingen</label><br />
                                    <textarea class="w-full text-sm" wire:model.lazy="remarks" placeholder="type.."></textarea>


                                </div>
                                <p class="text-sm text-gray-700">
                                    Opmerkingen
                                </p>
                            </div>

                        </div>


                        <div class="grid grid-cols-2 gap-4">




                            <div class="px-6 py-4 my-5">

                                <label class="text-sm" for="polarity">Debet of Credit</label><br />
                                <div class="form-row">
                                    <div class="pl-4 form-group col-md-1">
                                        <input type="radio" checked wire:model="polarity" value="1">
                                        <label for="polarity">{{ __('debet categorie') }}</label>
                                    </div>
                                    <div class="pl-4 form-group col-md-1">

                                        <input type="radio" wire:model="polarity" value="-1">
                                        <label for="polarity">{{ __('credit categorie') }}</label>
                                    </div>

                                    <p class="mt-2 text-sm text-gray-700">
                                        Debet categorieën zijn categorieën waarop je geld binnen krijgt. <br />
                                        Credit categorieën zijn categorieën waarop je geld uitgeeft.
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





    </div>


</div>



</div>
