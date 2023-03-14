<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3 ">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>


    {{-- <x-sidebar.link title="Boekingen" href="{{ route('bookings.index') }}">
        <x-slot name="icon">
            <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link> --}}


    @livewire('booking-account-menu')


    <x-sidebar.link title="Summary" href="{{ route('summary') }}">
        <x-slot name="icon">
            <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>




    <x-sidebar.link title="Balans" href="{{ route('balance') }}">
        <x-slot name="icon">
            <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>




    <x-sidebar.dropdown title="Categories" :active="Str::startsWith(
        request()
            ->route()
            ->uri(),
        'category',
    )">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        @livewire('booking-category-menu')

    </x-sidebar.dropdown>






    <x-sidebar.link title="Importeren" href="{{ route('importing') }}">
        <x-slot name="icon">
            <x-icons.upload class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>




</x-perfect-scrollbar>
