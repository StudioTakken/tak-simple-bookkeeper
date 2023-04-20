<div class="w-9/12">

    <div>
        Zoek: <input wire:model="search" type="text">
    </div>


    <div class="overflow-scroll border-b border-gray-200 shadow sm:rounded-lg">
        <table class="w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                    </th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Id</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        PId</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        <button wire:click="changeOrder" class="uppercase text-takred-500">Datum</button>
                    </th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Account
                    </th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Description
                    </th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Invoice</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                        Debet</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                        Credit</th>

                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Info</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Category</th>
                    <th scope="col"
                        class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        Kruis</th>

                </tr>
            </thead>






            {{-- include booking blade --}}


            @foreach ($bookings as $booking)
                @include('livewire.admin-row-booking-req', [
                    'booking' => $booking,
                    'include_children' => $include_children,
                ])
            @endforeach




            <tr class="">
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">

                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>

                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-right text-gray-500">
                    {{ $debet }}
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-right text-gray-500">
                    {{ $credit }}
                </th>
                <th scope="col" class="px-1 py-3 text-xs font-medium tracking-wider text-left text-gray-500">
                </th>

            </tr>




        </table>
    </div>

    @if (session('method') == 'account.onaccount')
        <div class='mt-5'>
            <p>Balans {{ session('startDate') }}: {{ number_format($start_balance / 100, 2, ',', '.') }} </p>
            <p>Balans {{ session('stopDate') }}: {{ number_format($end_balance / 100, 2, ',', '.') }}</p>
        </div>
    @endif
</div>
