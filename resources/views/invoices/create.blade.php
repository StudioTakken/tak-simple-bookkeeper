<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Invoices
        </h2>
    </x-slot>

    {{-- editform for new invoice --}}

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex w-9/12">
                        <div class="flex-none">
                            <h2 class="text-xl font-semibold leading-tight">
                                Create new invoice
                            </h2>
                        </div>
                        <div class="flex-grow"></div>
                        <div class="flex-none">
                            <button class="settingsbutton soft">
                                <a href="{{ route('invoices.index') }}">
                                    Back to invoices
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <label for="description">description</label>
                                <input type="text" name="description" id="description"
                                    value="{{ old('description') }}" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="amount">Amount</label>
                                <input type="text" name="amount" id="amount" value="{{ old('amount') }}" />
                            </div>

                            {{-- <div class="flex flex-col gap-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="account_id">Account</label>
                                <select name="account_id" id="account_id">
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div> --}}
                            <div class="flex flex-col gap-2">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" value="{{ old('date') }}" />
                            </div>


                            <div class="flex items-center justify-end mt-4 space-x-4">
                                <x-button class="ml-4">
                                    {{ __('Create') }}
                                </x-button>
                            </div>



                            <button type="submit" class="settingsbutton ">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
