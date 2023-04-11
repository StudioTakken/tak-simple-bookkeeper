<div>



    <div class="float-right w-9/12">

    </div>


    <table class="w-9/12 ">


        <thead class="border-b ">
            <tr>
                <th scope="col" class="w-4 h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                </th>
                <th scope="col" class="w-4 h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    Id</th>
                <th scope="col" class="w-4 h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    PId</th>
                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top w-28">
                    <button wire:click="changeOrder" class="text-takred-500">Datum</button>
                </th>
                <th scope="col" class="w-48 h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    Account
                </th>

                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    <div class="flex justify-between">
                        <div class="h-full">
                            Description
                        </div>
                        <div>
                            Zoek: <input wire:model="search" type="text">
                        </div>
                        <div>

                        </div>
                    </div>
                </th>

                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    Invoice</th>
                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-right align-top text-gray-9000 w-28">
                    Debet</th>
                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-right align-top text-gray-9000 w-28">
                    Credit</th>

                <th scope="col" class="w-10 h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top">
                    Info</th>
                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top w-28">
                    Category</th>
                <th scope="col" class="h-20 px-1 py-1 text-sm font-medium text-left text-gray-900 align-top w-28">
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
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">

            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>

            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            <th scope="col" class="px-1 font-mono text-sm font-bold text-right text-gray-900 py-7">
                {{ $debet }}
            </th>
            <th scope="col" class="px-1 font-mono text-sm font-bold text-right text-takred-900 py-7">
                {{ $credit }}
            </th>
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>

        </tr>




    </table>




    <div class='mt-5'>
        <p>Balans {{ session('startDate') }}: {{ $start_balance }} </p>
        <p>Balans {{ session('stopDate') }}: {{ $end_balance }}</p>
    </div>
</div>
