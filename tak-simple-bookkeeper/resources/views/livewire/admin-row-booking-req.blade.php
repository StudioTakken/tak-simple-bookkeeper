@livewire('admin-row-booking', ['booking' => $booking], key($booking->id . '-' . Str::random()))
@if ($booking->children)
    @foreach ($booking->children as $child)
        @include('livewire.admin-row-booking-req', ['booking' => $child])
    @endforeach
@endif
