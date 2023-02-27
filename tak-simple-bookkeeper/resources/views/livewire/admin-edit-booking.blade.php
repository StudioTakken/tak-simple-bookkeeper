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

    <div class="flex justify-end mb-3">
        @if ($booking->plus_min_int === 1)
            <div class="text-white btn bg-takgreen-500 btn-big"><i class="fa fas fa-plus " aria-hidden="true"></i>
            </div>
        @else
            <div class="text-white btn bg-takred-500 btn-big"><i class="fa fas fa-minus " aria-hidden="true"></i></div>
        @endif

    </div>





    <table class="w-full align-top border border-collapse border-slate-400">

        <tbody>

            <tr class='font-bold'>
                <td class="px-2 align-top border border-slate-300">Bedrag</td>
                <td class="px-2 align-top border border-slate-300">
                    {{ $amount_inc }}
                </td>
            </tr>

            <tr class=''>
                <td class="px-2 align-top border border-slate-300">Description</td>
                <td class="px-2 align-top border border-slate-300">
                    {{ $booking->description }}
                </td>
            </tr>

            @if ($booking->parent_id)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Parent booking</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->parent_id }}
                    </td>
                </tr>
            @endif

            @if ($booking->invoice_nr)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Invoice Nr</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->invoice_nr }}
                    </td>
                </tr>
            @endif

            @if ($booking->bank_code)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Bank code</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->bank_code }}
                    </td>
                </tr>
            @endif
            @if ($booking->bank_code)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Bank code</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->bank_code }}
                    </td>
                </tr>
            @endif
            @if ($booking->tag)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Tag</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->tag }}
                    </td>
                </tr>
            @endif

            @if ($booking->mutation_type)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Mutation type</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->mutation_type }}
                    </td>
                </tr>
            @endif

            @if ($booking->category)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Categorie</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->category }}
                    </td>
                </tr>
            @endif

            @if ($booking->remarks)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Remarks</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->remarks }}
                    </td>
                </tr>
            @endif

            @if ($booking->contra_account)
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Tegenrekening</td>
                    <td class="px-2 align-top border border-slate-300">
                        {{ $booking->contra_account }}
                    </td>
                </tr>
            @endif




            @if ($booking->category != 'btw')
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">BTW </td>
                    <td class="px-2 align-top border border-slate-300">
                        <button class="btn btn-red btn-small" wire:click="splitBookingBtw"><i class="fa fa-share-alt"
                                aria-hidden="true"></i> 21% btw
                            uitsplitsen</button>
                    </td>
                </tr>
                <tr class=''>
                    <td class="px-2 align-top border border-slate-300">Splitsen </td>
                    <td class="px-2 align-top border border-slate-300">



                        <button class="btn btn-red btn-small" wire:click="splitOffAction"><i class="fa fa-share-alt"
                                aria-hidden="true"></i>
                            uitsplitsen</button>

                        <input class="numberinputfield" type="text" wire:model="splitOffAmount"
                            placeholder="00,00" />

</div>


{{-- <input type="text" class="numberinputfield" placeholder="0000" /> --}}







{{-- <button class="btn btn-red btn-small" wire:click="splitBookingBtw"><i
                                    class="fa fa-share-alt" aria-hidden="true"></i>
                                uitsplitsen</button> --}}


</td>
</tr>

@endif



@if ($booking->originals)
    <tr class=''>
        <td class="px-2 align-top border border-slate-300">Reset</td>
        <td class="px-2 align-top border border-slate-300">
            <button class="btn btn-red btn-small" wire:click="resetBooking"><i class="fa fa-reply"
                    aria-hidden="true"></i> terug naar origineel </button>
        </td>
    </tr>
@endif

</tbody>
</table>
{{-- 
    @if ($booking->originals)
        <button class="btn btn-red btn-small" wire:click="resetBooking"><i class="fa fa-reply"
                aria-hidden="true"></i></button>
    @endif
    @if ($booking->category != 'btw')
        <button class="btn btn-red btn-small" wire:click="splitBookingBtw">21%</button>
    @endif --}}


{{-- 
    {
    "id":3,
    "parent_id":null,
    "date":"2023-01-09",
    "account":"NL94INGB0007001049",
    "contra_account":"",
    "description":"Hr M W J Takken",
    "plus_min":"plus",
    "plus_min_int":1,
    "invoice_nr":"0",
    "bank_code":"GT",
    "amount_inc":100000,
    "remarks":"Van Oranje spaarrekening T85720046 Valutadatum: 09-01-2023",
    "tag":"",
    "mutation_type":"Online bankieren",
    "category":"",
    "originals":{"tag":"",
    "date":"20230109",
    "account":"NL94INGB0007001049",
    "remarks":"Van Oranje spaarrekening T85720046 Valutadatum: 09-01-2023",
    "category":"",
    "plus_min":"plus",
    "bank_code":"GT",
    "amount_inc":100000,
    "invoice_nr":"0",
    "description":"Hr M W J Takken",
    "plus_min_int":1,
    "mutation_type":"Online bankieren",
    "contra_account":""},
    "created_at":"2023-02-24T21:30:30.000000Z",
    "updated_at":"2023-02-26T10:38:31.000000Z"

} --}}

</div>
