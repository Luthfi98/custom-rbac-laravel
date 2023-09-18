@extends('layouts.cms')

@section('title'){{ $title }}@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pos-products.update', $product->id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label for="name">Name :</label>
                                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <label for="description">Description :</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
                                {{-- <div id="ckeditor"></div> --}}
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="category_id">Category :</label>
                                    <select name="category_id" id="category_id" class="form-control select2">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $parentMenu)
                                            <option {{ $product->category_id == $parentMenu->id ? 'selected' : '' }} value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                                            @foreach ($parentMenu->child as $childMenu)
                                                <option {{ $product->category_id == $childMenu->id ? 'selected' : '' }} value="{{ $childMenu->id }}">- {{ $childMenu->name }}</option>
                                                @foreach ($childMenu->child as $subChildMenu)
                                                    <option {{ $product->category_id == $subChildMenu->id ? 'selected' : '' }} value="{{ $subChildMenu->id }}">-- {{ $subChildMenu->name }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="brand_id">Brand :</label>
                                    <select name="brand_id" id="brand_id" class="form-control select2">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $parentMenu)
                                            <option {{ $product->brand_id == $parentMenu->id ? 'selected' : '' }} value="{{ $parentMenu->id }}">{{ $parentMenu->name }}</option>
                                            @foreach ($parentMenu->child as $childMenu)
                                                <option {{ $product->brand_id == $parentMenu->id ? 'selected' : '' }} value="{{ $childMenu->id }}">- {{ $childMenu->name }}</option>
                                                @foreach ($childMenu->child as $subChildMenu)
                                                    <option {{ $product->brand_id == $parentMenu->id ? 'selected' : '' }} value="{{ $subChildMenu->id }}">-- {{ $subChildMenu->name }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach

                                    </select>
                                    @error('brand_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="price">Price :</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-text">Rp.</div>
                                        <input type="text" class="form-control" value="{{ $product->price }}" name="price" id="price">
                                    </div>
                                    @error('price')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-2 col-6">
                                <div class="form-group mt-3">
                                    <label for="qty">Qty :</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" value="{{ $product->qty }}" name="qty" id="qty">
                                    </div>
                                    @error('qty')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="form-group mt-3">
                                    <label for="unit_id">Unit:</label>
                                    <select name="unit_id" id="unit_id" class="form-control select2">
                                        @foreach ($units as $item)
                                            <option value="{{ $item->id }}" {{ $product->unit_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="image">Image:</label>
                                    <br>
                                    <img src="{{ url($product->image) }}" alt="" id="preview" width="250px">
                                    <input type="file" name="image" id="image" class="form-control">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="from-group mt-3">

                                    <label for="status">Status :</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="status" type="checkbox" id="status" {{ $product->status == 'Active' ? 'checked' : ''  }} value="Active">
                                        <label class="form-check-label" id="text-status" for="status">{{ $product->status == 'Active' ? 'Active' : 'InActive'  }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('pos-products.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
