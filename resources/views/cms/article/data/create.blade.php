@extends('layouts.cms')

@section('title'){{ $title }}@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('data-article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label for="name">Name :</label>
                                <input type="text" name="name" id="name" value="" class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <label for="content">Content :</label>
                                <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
                                {{-- <div id="ckeditor"></div> --}}
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <label for="category">Category :</label>
                                <select name="category" id="category" class="form-control select2">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="tags">Tags :</label>
                                <select name="tags[]" id="tags" class="form-control select2-tags" multiple>
                                    <option value="" disabled>Select Tags</option>
                                    @foreach ($tags as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group mt-3">
                            <label for="image">Image  : </label>
                            <br>
                            <img src="" alt="No Image" id="preview">

                            <input type="file" class="form-control" name="image" id="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('data-article.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                            <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                        </div>
                    </form>
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
    $(".select2-tags").select2({
        tags:true
    });
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
    .create( document.querySelector( '#content' ), {
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
