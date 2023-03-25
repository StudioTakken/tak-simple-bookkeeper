<td
    class="px-1 py-1 text-sm font-light text-gray-900 whitespace-nowrap

@if (session()->has('message')) @if (session('message') === 'success') 
success-fader @endif
@endif
@if (session()->has('message')) @if (session('message') === 'error') 
error-fader @endif
@endif

">
    <select @if ($booking->cross_account == '') style="color:#ff0000 !important;" @endif wire:model="cross_account"
        class="px-2 py-1 pr-8 text-sm text-left bg-white border-0 rounded shadow outline-none" name="cross_account">
        <option value="">
            Selecteer een account</option>

        @foreach ($booking_accounts as $account)
            <option class="pr-3" value='{{ $account->named_id }}'>{{ $account->name }}</option>
        @endforeach
    </select>
</td>
