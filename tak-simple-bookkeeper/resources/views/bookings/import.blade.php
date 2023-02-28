<x-app-layout>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ ucfirst($scope) }}
            </h2>
        </div>
    </x-slot>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif


    <div class="py-6">



        <a href="{{ route('bookings.import') }}">
            <x-button size="base" class="items-center gap-2">
                <x-heroicon-o-home aria-hidden="true" class="w-4 h-4" />
                <span>Import</span>
            </x-button>
        </a>


    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">



                <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data"
                    id="image-upload" class="dropzone">
                    @csrf
                    <div class="dz-message" data-dz-message><span>Drop je Bank cvs hier</span></div>
                    {{-- <div>
                        <h4>Upload Multiple Image By Click On Box</h4>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        var dropzone = new Dropzone('#image-upload', {
            thumbnailWidth: 200,
            maxFilesize: 1,
            acceptedFiles: ".csv"
        });
    </script>


</x-app-layout>
