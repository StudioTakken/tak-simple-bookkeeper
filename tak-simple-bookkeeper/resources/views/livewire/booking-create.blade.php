<div class="w-4/6">

    <div x-data="{ open: false }">
        <button class="mb-5 text-white btn bg-takgreen-500 btn-small" x-on:click="open = ! open">
            {{-- <button class="float-right mb-5" x-on:click="open = ! open"> --}}
            <i class="fa fas fa-plus"></i>
            {{-- {{ $account->name }} item --}}
        </button>

        <div x-show="open">

            <div wire:loading.class.remove="success-fader" wire:loading.class.remove="error-fader"
                class=" overflow-hidden rounded shadow-lg m-10 p-10
                @if (session()->has('message')) @if (session('message') === 'success')
                success-fader @endif
                @endif
                @if (session()->has('message')) @if (session('message') === 'error')
                error-fader @endif
                @endif
                ">

                <h2 class="font-bold">Nieuw item in {{ $account->name }}</h2>
                <p class="text-sm">
                    De booking wordt gedaan in het huidige account.<br />
                    Categorie toekennen kan in de volgende stap.
                </p>

                @if ($account->slug === 'bank')
                    <div class="p-4 m-5 text-orange-700 bg-orange-100 border-l-4 border-orange-500" role="alert">
                        <p class="font-bold">Let op</p>
                        <p>Het ligt niet voor de hand een handmatige boeking te doen in het account
                            {{ $account->name }}. Zie de importeer functie.</p>
                    </div>
                @endif


                <form class="" wire:submit.prevent="submit">

                    <div>
                        <input type="hidden" value={{ $account->slug }}>
                    </div>

                    <div class="py-1 text-sm font-light text-gray-900 whitespace-nowrap">

                        <label for="date">Datum</label><br />
                        {{-- date --}}
                        <input class="py-0 text-sm border-gray-400" type="date" wire:model="date" id="date"
                            name="date">
                        @error('date')
                            <br />
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="py-1 text-sm font-light text-gray-900 whitespace-nowrap">
                        <label for="description">Omschrijving</label><br />
                        {{-- description --}}
                        <input class="py-0 text-sm border-gray-400" type="text" wire:model.lazy="description">
                        @error('description')
                            <br />
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="py-1 text-sm font-light text-gray-900 whitespace-nowrap">
                        <label for="amount">Bedrag</label><br />

                        <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                            class="numberinputfield" />


                        @error('amount_inc')
                            <br />
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- polarity --}}

                    <div class="py-1 text-sm font-light text-gray-900 whitespace-nowrap">
                        <label for="polarity">Plus of Min</label><br />
                        <select class="py-0 text-sm border-gray-400" wire:model="polarity">
                            <option value="1">Plus</option>
                            <option value="-1">Min</option>
                        </select>
                        @error('polarity')
                            <br />
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>


                        <button class="mt-5 text-white btn bg-takgreen-500 btn-small">
                            <i class="fa fas fa-plus" aria-hidden="true"></i> Boek item
                        </button>

                    </div>
                </form>


            </div>
        </div>

    </div>
</div>
