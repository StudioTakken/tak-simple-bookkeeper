<div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data" id="prove-upload"
                    class="dropzone">
                    @csrf
                    <div class="dz-message" data-dz-message><span>Drop your prove</span>

                    </div>
                    <input type="hidden" name="prove" value="booking">
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        var dropzone = new Dropzone('#prove-upload', {
            thumbnailWidth: 200,
            maxFilesize: 5,
            //   acceptedFiles: ".csv, .pdf, .jpg, .xls, .xlsx, .doc",
            success: function(file, response) {
                @this.emit('refreshBookings')
            }
        });
    </script>


</div>
