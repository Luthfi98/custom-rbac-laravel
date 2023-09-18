@extends('layouts.cms')

@section('title'){{ $title }}@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('cms/vendor/select2/css/select2.min.css') }} ">
@endsection

@section('js')
<script src="{{ asset('cms/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('cms/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('cms/vendor/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    $(".select2").select2();
    $("#status").change(function() {
        var statusText = $("#text-status");
        if ($(this).is(":checked")) {
        statusText.text("Active");
        } else {
        statusText.text("Inactive");
        }
    });

    $('#image').on('change', function() {
        var input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Update the source of the preview image with the selected image
                $('#preview').attr('src', e.target.result).attr('hidden', false);
            };

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#preview').attr('hidden', true);
        }
    })

    ClassicEditor
    .create( document.querySelector( '#description' ), {
        toolbar: {
            items: [
                'heading',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                'blockQuote',
                'undo',
                'redo'
            ]
        },
    } )
    .then( editor => {
        window.editor = editor;
    } )
    .catch( err => {
        console.error( err.stack );
    } );


</script>
@endsection
