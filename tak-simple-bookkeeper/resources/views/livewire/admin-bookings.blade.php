<div>
    -- {{ $freshnow }} --
    <table class="min-w-full">
        <thead class="border-b">
            <tr>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left"></th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Id</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">PId</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Date</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Description</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-right">Deb Incl BTW</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-right">Cred Incl BTW</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-right">Bewerk</th>
                {{-- <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-right">Bedrag Excl BTW --}}
                {{-- </th> --}}
                {{-- <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-right">BTW</th> --}}
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Category</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Remarks</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Account</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Tegenrekening</th>
                {{-- <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Subcategory</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-1 py-1 text-left">Tags</th> --}}
            </tr>
        </thead>



        @foreach ($bookings as $booking)
            @livewire('admin-row-booking', ['booking' => $booking], key($booking->id . '-' . Str::random()))
        @endforeach
    </table>
</div>
