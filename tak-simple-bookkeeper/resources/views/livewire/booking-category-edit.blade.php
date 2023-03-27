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


                        <div class="grid grid-cols-2 gap-4">




                            <div class="px-6 py-4 my-5">

                                <label class="text-sm" for="opmerkingen">Debet of Credit</label><br />
                                <div class="form-row">
                                    <div class="pl-4 form-group col-md-1">
                                        <input type="radio" checked wire:model="category.plus_min_int" value="1">
                                        <label for="plus_min_int">{{ __('debet categorie') }}</label>
                                    </div>
                                    <div class="pl-4 form-group col-md-1">

                                        <input type="radio" wire:model="category.plus_min_int" value="-1">
                                        <label for="plus_min_int">{{ __('credit categorie') }}</label>
                                    </div>

                                    <p class="mt-2 text-sm text-gray-700">
                                        Debet categorieën zijn categorieën waarop je geld binnen krijgt. <br />
                                        Credit categorieën zijn categorieën waarop je geld uitgeeft.
                                    </p>
                                </div>

                            </div>




                            <div class="">
                                <div class="flex justify-end px-6 py-4 mb-3">
                                    @if ($category->plus_min_int == 1)
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



                            @if (isset($category))
                                <div class="mt-5">
                                    <button
                                        class="px-4 py-1 text-sm text-black bg-gray-100 border border-gray-600 rounded hover:bg-gray-300">
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
