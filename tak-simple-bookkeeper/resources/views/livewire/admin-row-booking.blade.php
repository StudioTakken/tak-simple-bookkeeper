<tr 
x-data="{ activated: false }" 
x-on:click="activated = true" 
x-on:click.outside="activated = false"
:class="activated ? 'activated' : ''"
wire:click="openSidePanel" 

class="
border-t-2 border-gray-200
@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif
"
    wire:loading.class.remove="success-fader" wire:loading.class.remove="error-fader" wire:loading.class.remove="active">

    <td id="{{ $booking->id }}" class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap ">

        {{ $active }}
        @if (session()->has('message'))
            @if (session('message') === 'error')
                X - please reload! @endif
        @endif

    </td>


    <td class="px-1 py-1 text-sm font-light text-gray-900 cursor-pointer whitespace-nowrap">
        {{ $booking->id }}
    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->parent_id }}</td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">
        {{ $booking->date }}
    </td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">{{ $booking->account }}</td>
    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">

        {{-- <input type="text" wire:model.debounce.4s="description" wire:change="updateDescription"
            class="descriptioninputfield" /> --}}

        {{ $booking->description }}

    </td>



    <td
        class="px-1 py-1 font-mono text-sm font-light text-left whitespace-nowrap
    
    @if ($balance) text-green-700 
   @else
    text-red-700 @endif
    
    ">
        {{ $booking->invoice_nr }}
    </td>


    @if ($booking->polarity < 0)
        <td class="px-1 py-1 font-mono text-sm font-light text-right text-gray-900 whitespace-nowrap">

        </td>
        <td class="font-mono text-right text-red-700">

            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />
        </td>
    @else
        <td class="font-mono text-right">
            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />
        </td>

        <td class="px-1 py-1 font-mono text-sm font-light text-right text-gray-900 whitespace-nowrap">
        </td>

    @endif

    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">
        <button class="text-white btn bg-takgreen-500 btn-small" wire:click="openSidePanel"><i class="fa fas fa-info"
                aria-hidden="true"></i> </button>
    </td>

    <td class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap">
        <select @if ($booking->category == '') style="color:#ff0000 !important;" @endif wire:model="category"
            class="px-2 py-1 pr-8 text-sm text-left bg-white border-0 rounded shadow outline-none" name="category">
            <option value="">
                Selecteer een categorie</option>

            @foreach ($listOfCategories as $category)
                <option class="pr-3" value='{{ $category['id'] }}'>{{ $category['name'] }}</option>
            @endforeach
            @foreach ($listOfCrossCategoryAccounts as $crossCategory)
                <option class="pr-3" value='{{ $crossCategory['category'] }}::{{ $crossCategory['named_id'] }}'>
                    naar:
                    {{ $crossCategory['name'] }}
                </option>
            @endforeach




        </select>
    </td>

    @if ($booking->booking_category and $booking->booking_category->named_id == 'cross-posting')
        @livewire ('booking-account-chooser', ['booking' => $booking], key($booking->id))
    @endif

</tr>
