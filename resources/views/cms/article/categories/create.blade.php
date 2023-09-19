@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('article-category.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="parent">Parent:</label>
                            <select name="parent" id="parent" class="form-control select2">
                                <option value="">Select Parent</option>
                                @foreach ($parents as $parentMenu)
                                    <option value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                                    @foreach ($parentMenu->child as $childMenu)
                                        <option value="{{ $childMenu->id }}">- {{ $childMenu->name }}</option>
                                        @foreach ($childMenu->child as $subChildMenu)
                                            <option value="{{ $subChildMenu->id }}">-- {{ $subChildMenu->name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                            @error('parent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                            <a href="{{ route('article-category.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
<script type="text/javascript">
    $(".select2").select2();
    $('#image').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // Update the source of the preview image with the selected image
            $('#preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        }
    });
</script>
@endsection
