<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Backups') }}
        </h2>
    </x-slot>


    <button class="mb-10 settingsbutton soft">
        <a href="{{ route('backitup') }}">Make a database backup</a>
    </button>




    @if (session()->has('message'))
        <div class="flex items-center px-4 py-3 mb-5 text-sm font-bold text-white bg-green-500" role="alert">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="flex items-center px-4 py-3 mb-5 text-sm font-bold text-white bg-takred-500" role="alert">
            <p>{{ session()->get('error') }}</p>
        </div>
    @endif


    <div class="space-y-6">


        <div class="flex items-start w-full grid-cols-2 gap-8 mb-4">


            <div class="grid w-3/4 grid-cols-5 gap-4">


                <div class="col-span-2 font-bold">File</div>
                <div class="font-bold ">File Size</div>
                <div class="font-bold ">Aangemaakt op</div>
                <div class="font-bold ">Restore</div>


                @foreach ($backups as $backup)
                    <div class="col-span-2">{{ $backup['file_name'] }}</div>
                    <div>{{ number_format($backup['file_size'] / 1024, 2, ',', '.') }} Mb</div>
                    <div>{{ $backup['last_modified'] }}</div>
                    <div>
                        <button class="settingsbutton soft">
                            <a href="{{ route('restore', ['file' => $backup['file_name']]) }}">Restore</a>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-sm my-44">
            {{ $mysqldump }}
        </div>


    </div>
</x-app-layout>
