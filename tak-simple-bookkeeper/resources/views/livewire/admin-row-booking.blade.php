{{-- The whole world belongs to you. --}}


<tr>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->date }}</td>
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->description }}
    </td>


    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
        {{ number_format($booking->amount_inc / 100, 2, ',', '.') }}
    </td>

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

    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
        {{ number_format($booking->amount / 100, 2, ',', '.') }}
    </td>


    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap text-right">
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
    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $booking->remarks }}</td>
</tr>
