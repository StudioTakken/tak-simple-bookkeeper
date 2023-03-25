<div>
    @foreach ($categories as $categories)
        <x-sidebar.link title="{{ $categories->name }}"
            href="{{ route('category.oncategory', ['category' => $categories->slug]) }}">
            <x-slot name="icon">
                <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endforeach
</div>
