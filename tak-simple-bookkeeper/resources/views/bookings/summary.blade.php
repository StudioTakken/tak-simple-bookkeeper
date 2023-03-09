<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Summary periode: {{ Session::get('startDate') }} - {{ Session::get('stopDate') }}

            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="py-6">

        <div class="flex items-start w-4/6 grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @foreach ($summery as $key => $item)
                    @if ($item['debet'] > 0)
                        <div>
                            {{ $item['name'] }} - {{ $key }}
                        </div>
                        <div class='text-right'>
                            {{ $item['debet'] }}
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @foreach ($summery as $key => $item)
                    @if ($item['credit'] > 0)
                        <div>
                            {{ $item['name'] }} - {{ $key }}
                        </div>
                        <div class='text-right'>
                            {{ $item['credit'] }}
                        </div>
                    @endif
                @endforeach
            </div>

        </div>


        {{-- here the divs for the totals --}}
        <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-8 font-bold">

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='text-right'>
                    {{ $totals['debet'] }}
                </div>


            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='text-right'>
                    {{ $totals['credit'] }}
                </div>


            </div>

        </div>




    </div>
</x-app-layout>
