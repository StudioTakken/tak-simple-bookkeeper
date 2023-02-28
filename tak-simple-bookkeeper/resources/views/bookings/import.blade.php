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


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data"
                    id="bank-csv-upload" class="dropzone">
                    @csrf
                    <div class="dz-message" data-dz-message><span>Drop je ING Bank cvs hier</span></div>
                    <input type="hidden" name="gb_rek" value="ING">
                </form>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data"
                    id="debiteuren-csv-upload" class="dropzone">

                    @csrf
                    <div class="dz-message" data-dz-message><span>Drop je Debiteuren excel hier</span></div>
                    <input type="hidden" name="gb_rek" value="Debiteuren">
                </form>
            </div>
        </div>
    </div>




    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        var dropzone = new Dropzone('#bank-csv-upload', {
            thumbnailWidth: 200,
            maxFilesize: 1,
            acceptedFiles: ".csv"
        });

        var dropzone = new Dropzone('#debiteuren-csv-upload', {
            thumbnailWidth: 200,
            maxFilesize: 1,
            acceptedFiles: ".xlsx"
        });
    </script>


</x-app-layout>
