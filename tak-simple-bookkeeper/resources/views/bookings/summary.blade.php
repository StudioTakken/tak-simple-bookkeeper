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
        <button class="px-4 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
            <a href="{{ route('summary.filter', 'inout') }}">In en Uit</a>
        </button>
        <button class="px-4 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
            <a href="{{ route('summary.filter', 'venw') }}">Verlies en Winst</a>
        </button>
        <button class="px-4 py-1 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
            <a href="{{ route('summary.filter', 'btw') }}">BTW overzicht</a>
        </button>
    </div>




    <div class="py-6">

        <div class="flex items-start w-4/6 grid-cols-2 gap-8">

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @foreach ($summery['debet'] as $key => $item)
                    <div>
                        {{ $item['name'] }}
                    </div>
                    <div class='font-mono text-right'>
                        {{ $item['debet'] }}
                    </div>
                @endforeach
            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">
                @foreach ($summery['credit'] as $key => $item)
                    <div>
                        {{ $item['name'] }}
                    </div>
                    <div class='font-mono text-right'>
                        {{ $item['credit'] }}
                    </div>
                @endforeach
            </div>

        </div>


        {{-- here the divs for the totals --}}
        <div class="flex items-start w-4/6 grid-cols-2 gap-8 mt-8 font-bold">

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='font-mono text-right'>
                    {{ $totals['debet'] }}
                </div>


            </div>

            <div class="grid w-1/2 grid-cols-2 gap-4">


                <div>
                    Totaal
                </div>
                <div class='font-mono text-right'>
                    {{ $totals['credit'] }}
                </div>


            </div>

        </div>




    </div>
</x-app-layout>
