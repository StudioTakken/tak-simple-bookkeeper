<div>
    @foreach ($accounts as $account)
        <x-sidebar.link title="{{ $account->name }}"
            href="{{ route('account.onaccount', ['account' => $account->slug]) }}">
            <x-slot name="icon">
                <x-icons.list class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endforeach
</div>
