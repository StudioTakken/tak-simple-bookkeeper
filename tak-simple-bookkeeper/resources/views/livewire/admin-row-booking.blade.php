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

    <td id="{{ $booking->id }}" class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap ">

        @if (session()->has('message'))
            @if (session('message') === 'error')
                X - please reload! @endif
        @endif

    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->id }}</td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->parent_id }}</td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->date }}</td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->description }}
    </td>

    @if ($booking->plus_min_int < 0)
        <td class="px-1 py-1 text-sm font-light text-right text-gray-900 whitespace-nowrap">

        </td>
        <td class="text-red-700 ">

            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />

        </td>
    @else
        <td class="">
            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />

        </td>

        <td class="px-1 py-1 text-sm font-light text-right text-gray-900 whitespace-nowrap">
        </td>

    @endif

    <td class="px-1 py-1 text-sm font-light text-right text-gray-900 whitespace-nowrap">

        <button class="btn btn-red btn-small" wire:click="openSidePanel"><i class="fa fas fa-info"
                aria-hidden="true"></i></button>


        @if ($booking->originals)
            <button class="btn btn-red btn-small" wire:click="resetBooking"><i class="fa fa-reply"
                    aria-hidden="true"></i></button>
        @endif

        @if ($booking->category != 'btw')
            <button class="btn btn-red btn-small" wire:click="splitBookingBtw">21%</button>
        @endif

    </td>



    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">

        <select @if ($booking->category == '') style="color:#ff0000 !important;" @endif wire:model="category"
            class="px-2 py-1 pr-8 text-sm text-left bg-white border-0 rounded shadow outline-none" name="category">
            <option value="">
                Selecteer een categorie</option>

            @foreach (config('bookings.categories') as $category => $catname)
                <option class="pr-3" value='{{ $category }}'>{{ $catname }}</option>
            @endforeach
        </select>
    </td>
    {{-- <td class="px-1 py-1 text-sm font-light text-gray-900 w-60">
        <div class="w-full h-6 overflow-auto hover:h-full">
            <p class="overflow-auto">
                {{ $booking->remarks }}</p>
        </div>
    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">
        {{ $booking->account }}
    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">
        {{ $booking->contra_account }}</td>

    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->bank_code }}
    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->tags }}</td> --}}
</tr>
