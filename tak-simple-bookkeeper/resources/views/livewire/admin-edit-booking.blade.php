<div
    class="
@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif
">

    <ul>

        {{-- <li>
            <input type="text" wire:model.debounce.4s="amount_inc" wire:change="updateAmountInc"
                class="numberinputfield" />
        </li> --}}


        <li>{{ $amount_inc }} </li>
        @if ($booking->parent_id)
            <li>Parent booking: {{ $booking->parent_id }} </li>
        @endif
        <li>Description: {{ $booking->description }} </li>
        <li>Plus Min: {{ $booking->plus_min }} </li>
        <li>Plus Min Int: {{ $booking->plus_min_int }} </li>
        <li>Invoice Nr: {{ $booking->invoice_nr }} </li>
        <li>Bank Code: {{ $booking->bank_code }} </li>
        <li>Remarks: {{ $booking->remarks }} </li>
        <li>Tag: {{ $booking->tag }} </li>
        <li>Mutation Type: {{ $booking->mutation_type }} </li>
        <li>Category: {{ $booking->category }} </li>

        {{-- <li>Originals: {{ $booking->originals }} </li> --}}


    </ul>


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
