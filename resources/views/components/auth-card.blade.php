<main class="flex flex-col items-center flex-1 px-4 pt-6 sm:justify-center">
    <div class="">
        <a href="/">
            <x-application-logo class="h-20 w-80" />
            {{-- <div class="w-96">
                <img src="{{ url('storage/images/logo_studiotakken.png') }}" />
            </div> --}}
        </a>
    </div>

    <div class="w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-md sm:max-w-md dark:bg-dark-eval-1">
        {{ $slot }}
    </div>
</main>
