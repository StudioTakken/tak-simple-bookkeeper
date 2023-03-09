<div>



    <table class="w-2/3 ">
        <thead class="border-b ">
            <tr>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                </th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    Id</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    PId</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    Date
                </th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    Account</th>

                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    Description</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Debet</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Credit</th>
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Bewerk</th> --}}
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Bedrag Excl BTW --}}
                {{-- </th> --}}
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">BTW</th> --}}
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">
                    Category</th>
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Remarks</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Account</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Tegenrekening</th> --}}
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Subcategory</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Tags</th> --}}
            </tr>
        </thead>


        {{-- include booking blade --}}


        @foreach ($bookings as $booking)
            @include('livewire.admin-row-booking-req', ['booking' => $booking])
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
            <th scope="col" class="px-1 text-sm font-bold text-right text-gray-900 py-7">
                {{ $debet }}
            </th>
            <th scope="col" class="px-1 text-sm font-bold text-right text-takred-900 py-7">{{ $credit }}
            </th>
            {{-- <th scope="col" class="px-1 text-sm font-medium text-right text-gray-900 py-7">Bewerk</th> --}}
            {{-- <th scope="col" class="px-1 text-sm font-medium text-right text-gray-900 py-7">Bedrag Excl BTW --}}
            {{-- </th> --}}
            {{-- <th scope="col" class="px-1 text-sm font-medium text-right text-gray-900 py-7">BTW</th> --}}
            <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">
            </th>
            {{-- <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">Remarks</th>
                <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">Account</th>
                <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">Tegenrekening</th> --}}
            {{-- <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">Subcategory</th>
                <th scope="col" class="px-1 text-sm font-medium text-left text-gray-900 py-7">Tags</th> --}}
        </tr>




    </table>
</div>
