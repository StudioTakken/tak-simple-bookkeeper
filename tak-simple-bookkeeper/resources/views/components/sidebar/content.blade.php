<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3 ">

    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown title="Buttons" :active="Str::startsWith(
        request()
            ->route()
            ->uri(),
        'buttons',
    )">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Text button" href="{{ route('buttons.text') }}" :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}" :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown>


    {{-- <x-sidebar.link title="Boeking" href="{{ route('bookings.edit', 1) }}" /> --}}
    <x-sidebar.link title="Boekingen" href="{{ route('bookings.index') }}">
        <x-slot name="icon">
            <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Importeren" href="{{ route('importing') }}">
        <x-slot name="icon">
            <x-icons.upload class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>


    {{-- <x-sidebar.link title="Debiteuren" href="{{ route('debiteuren.index') }}" /> --}}



    <x-sidebar.dropdown title="Categories" :active="Str::startsWith(
        request()
            ->route()
            ->uri(),
        'category',
    )">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        {{-- <x-sidebar.sublink title="Text button" href="{{ route('buttons.text') }}" :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink title="Icon button" href="{{ route('buttons.icon') }}" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="{{ route('buttons.text-icon') }}" :active="request()->routeIs('buttons.text-icon')" /> --}}

        @foreach (config('bookings.categories') as $key => $category)
            <x-sidebar.sublink title="{{ $category }}"
                href="{{ route('category.oncategory', ['category' => $key]) }}" :active="Str::startsWith(Request::getPathInfo(), '/category/' . $key)" />
        @endforeach

    </x-sidebar.dropdown>







    {{-- <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">
        Categorieën
    </div>
    @foreach (config('bookings.categories') as $key => $category)
        <x-sidebar.link title="{{ $category }}" href="{{ route('category.oncategory', ['category' => $key]) }}" />
    @endforeach --}}



    {{-- <div x-transition x-show="isSidebarOpen || isSidebarHovered" class="text-sm text-gray-500">
        Dummy Links
    </div>

    @php
        $links = array_fill(0, 5, '');
    @endphp

    @foreach ($links as $index => $link)
        <x-sidebar.link title="Dummy link {{ $index + 1 }}" href="#" />
    @endforeach --}}

</x-perfect-scrollbar>
