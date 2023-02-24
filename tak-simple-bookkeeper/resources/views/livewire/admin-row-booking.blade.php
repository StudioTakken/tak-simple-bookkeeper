<tr class="   

border-t-2 border-gray-200
@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif
"
    wire:loading.class.remove="success-fader" wire:loading.class.remove="error-fader">


    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap ">

        @if (session()->has('message'))
            @if (session('message') === 'error')
                X - please reload! @endif
        @endif


    </td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->id }}</td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->parent_id }}</td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->date }}</td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->description }}
    </td>



    @if ($booking->plus_min_int < 0)
        <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap text-right">

        </td>
        <td class=" text-red-700">

            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />

        </td>
    @else
        {{-- <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap text-right"> --}}
        {{--  --}}
        {{-- {{ number_format($booking->amount_inc / 100, 2, ',', '.') }} --}}
        {{-- </td> --}}

        <td class="">
            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />

        </td>


        <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap text-right">

        </td>

    @endif

    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap text-right">


        @if ($booking->amount == 0 and $booking->btw == 0)
            <button class="btn btn-blue btn-small" wire:click="splitAmountBtw">-> btw</button>
        @endif
        @if ($booking->amount_inc == 0 and $booking->btw == 0)
            <button class="btn btn-blue btn-small" wire:click="CalcAmountIncAndBtw">btw <- </button>
        @endif


        @if ($booking->amount_inc == 0 or $booking->amount == 0)
            <button class="btn btn-red btn-small" wire:click="NoBTW">geen btw</button>
        @endif

        @if ($booking->originals)
            <button class="btn btn-red btn-small" wire:click="resetBooking">reset</button>
        @endif


        <button class="btn btn-red btn-small" wire:click="splitBooking">split</button>

    </td>



    <td
        class="text-sm @if ($booking->plus_min_int < 0) text-red-600 @else text-gray-900 @endif font-light px-1 py-1 whitespace-nowrap text-right">
        {{ number_format($booking->amount / 100, 2, ',', '.') }}
    </td>


    <td
        class="text-sm @if ($booking->plus_min_int < 0) text-red-600 @else text-gray-900 @endif font-light px-1 py-1 whitespace-nowrap text-right">
        {{ number_format($booking->btw / 100, 2, ',', '.') }}
    </td>

    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">

        <select @if ($booking->category == '') style="color:#ff0000 !important;" @endif wire:model="category"
            class="px-2 py-1 pr-8 bg-white rounded text-sm border-0 shadow outline-none text-right" name="category">
            <option value="">
                Selecteer een categorie</option>

            @foreach (config('bookings.categories') as $category => $catname)
                <option class="pr-3" value='{{ $category }}'>{{ $catname }}</option>
            @endforeach
        </select>






    </td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->bank_code }}
    </td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">
        {{ $booking->account }}
    </td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">
        {{ $booking->contra_account }}</td>

    <td class="text-sm text-gray-900 font-light px-1 py-1 whitespace-nowrap">{{ $booking->tags }}</td>
    <td class="text-sm text-gray-900 font-light px-1 py-1 w-60">
        <div class="w-full h-6 overflow-auto  hover:h-full">
            <p class="overflow-auto">
                {{ $booking->remarks }}</p>
        </div>
    </td>
</tr>


@if ($booking->children)
    @foreach ($booking->children as $child)
        @livewire('admin-row-booking', ['booking' => $child])
    @endforeach
@endif
