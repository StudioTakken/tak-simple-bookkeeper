<div>
    -- {{ $freshnow }} --
    <table class="min-w-full">
        <thead class="border-b">
            <tr>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left"></th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Id</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Parent</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Date</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Description</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Deb Incl BTW</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Cred Incl BTW</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bewerk</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">Bedrag Excl BTW
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-right">BTW</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Category</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Subcategory</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Account</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tegenrekening</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Tags</th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Remarks</th>
            </tr>
        </thead>



        @foreach ($bookings as $booking)
            @livewire('admin-row-booking', ['booking' => $booking])
        @endforeach
    </table>
</div>
