<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Balans
            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif



    <div class="w-full py-6">



        <div class="flex items-start w-full grid-cols-2 gap-8 mb-4">

            <div class="grid w-1/2 grid-cols-3 gap-4 font-bold">

                <div class="">
                    Account
                </div>
                <div class='text-right '>
                    {{ Session::get('startDate') }}
                </div>
                <div class='text-right '>
                    {{ Session::get('stopDate') }}
                </div>

            </div>

        </div>



        <div class="flex items-start w-full grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-3 gap-4">
                @foreach ($balance as $key => $details)
                    <div>
                        {{ $details['name'] }}
                    </div>
                    <div class='font-mono text-right'>
                        {{ $details['start'] }}
                    </div>
                    <div class='font-mono text-right'>
                        {{ $details['end'] }}
                    </div>
                @endforeach
            </div>

        </div>


        <div class="flex items-start w-full grid-cols-2 gap-8 mt-5 font-bold">

            <div class="grid w-1/2 grid-cols-3 gap-4">

                <div>
                    Totals
                </div>
                <div class='font-mono text-right'>
                    {{ $balancetotals['start'] }}
                </div>
                <div class='font-mono text-right'>
                    {{ $balancetotals['end'] }}
                </div>

            </div>

        </div>





</x-app-layout>
