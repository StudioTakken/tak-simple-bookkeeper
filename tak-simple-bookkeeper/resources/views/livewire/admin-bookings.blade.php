<div>
    <table class="w-2/3">
        <thead class="border-b">
            <tr>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900"></th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Id</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">PId</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Date</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Description</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Deb Incl BTW</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Cred Incl BTW</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Bewerk</th>
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">Bedrag Excl BTW --}}
                {{-- </th> --}}
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-right text-gray-900">BTW</th> --}}
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Category</th>
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Remarks</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Account</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Tegenrekening</th> --}}
                {{-- <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Subcategory</th>
                <th scope="col" class="px-1 py-1 text-sm font-medium text-left text-gray-900">Tags</th> --}}
            </tr>
        </thead>



        @foreach ($bookings as $booking)
            @livewire('admin-row-booking', ['booking' => $booking], key($booking->id . '-' . Str::random()))
        @endforeach






    </table>
</div>
