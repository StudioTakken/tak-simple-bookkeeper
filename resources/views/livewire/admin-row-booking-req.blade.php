@livewire('admin-row-booking', ['booking' => $booking], key($booking->id . '-' . Str::random()))
@if ($booking->children)
    @foreach ($booking->children as $child)
        @if ($include_children or $child->category == $booking->category)
            @include('livewire.admin-row-booking-req', ['booking' => $child])
        @endif
    @endforeach
@endif
