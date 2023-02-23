<tr class="   
@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif
"
    wire:loading.class.remove="success-fader" wire:loading.class.remove="error-fader">


    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">

        @if (session()->has('message'))
            @if (session('message') === 'error')
                X - reload! @endif
        @endif


    </td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->date }}</td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->description }}
    </td>



    @if ($booking->plus_min_int < 0)
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">

        </td>
        <td class="text-sm font-light px-6 py-4 whitespace-nowrap text-right text-red-700">
            {{ number_format($booking->amount_inc / 100, 2, ',', '.') }}
        </td>
    @else
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
            {{ number_format($booking->amount_inc / 100, 2, ',', '.') }}
        </td>
        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">

        </td>

    @endif

    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">


        @if ($booking->amount == 0 and $booking->btw == 0)
            <button class="btn btn-blue btn-small" wire:click="splitAmountBtw">-> btw</button>
        @endif
        @if ($booking->amount_inc == 0 and $booking->btw == 0)
            <button class="btn btn-blue btn-small" wire:click="CalcAmountIncAndBtw">btw <- </button>
        @endif


        @if ($booking->amount_inc == 0 or $booking->amount == 0)
            <br /><button class="btn btn-red btn-small" wire:click="NoBTW">geen btw</button>
        @endif

        <br />
        <button class="btn btn-red btn-small" wire:click="resetBooking">reset</button>

    </td>



    <td
        class="text-sm @if ($booking->plus_min_int < 0) text-red-600 @else text-gray-900 @endif font-light px-6 py-4 whitespace-nowrap text-right">
        {{ number_format($booking->amount / 100, 2, ',', '.') }}
    </td>


    <td
        class="text-sm @if ($booking->plus_min_int < 0) text-red-600 @else text-gray-900 @endif font-light px-6 py-4 whitespace-nowrap text-right">
        {{ number_format($booking->btw / 100, 2, ',', '.') }}
    </td>

    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
        {{ $booking->category }}<br />

        <select @if ($booking->category == '') style="color:#ff0000 !important;" @endif wire:model="category"
            name="category">
            <option value="">Selecteer een categorie</option>

            @foreach (config('bookings.categories') as $category => $catname)
                <option value='{{ $category }}'>{{ $catname }}</option>
            @endforeach
        </select>






    </td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->bank_code }}
    </td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
        {{ $booking->account }}
    </td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
        {{ $booking->contra_account }}</td>

    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->tags }}</td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 w-60">
        <div class="w-full h-6 overflow-auto  hover:h-full">
            <p class="overflow-auto">
                {{ $booking->remarks }}</p>
        </div>
    </td>
</tr>
