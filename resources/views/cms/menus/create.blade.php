@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('menus.store') }}">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="parent">Parent Menu:</label>
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

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mt-3">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mt-3">
                                    <label for="module">Module:</label>
                                    <input type="text" name="module" id="module" class="form-control" required>
                                    @error('module')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group mt-3">
                            <label for="path">Path:</label>
                            <input type="text" name="path" id="path" class="form-control" required>
                            @error('path')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="icon">Icon:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-text"><span id="show-icon"></span></div>
                                <input type="text" class="form-control" id="icon" name="icon" required>
                            </div>
                            @error('icon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md 6 col-12">
                                <div class="form-group mt-3">
                                    <label for="type">Type:</label> <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked type="radio" name="type" id="cms" value="cms">
                                        <label class="form-check-label" for="cms">CMS</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type" id="landing" value="landing">
                                        <label class="form-check-label" for="landing">Landing</label>
                                    </div>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md 6 col-12">
                                <div class="form-group mt-3">
                                    <label for="is_label">Is Label:</label> <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="is_label" id="is_label">
                                        <label class="form-check-label" for="is_label" id="text-is-label">No</label>
                                    </div>
                                    @error('is_label')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label for="permissions[]">Permissions:</label>
                            <select name="permissions[]" id="permissions[]" multiple class="form-control select2-multiple">
                                <option value="" disabled>Select Permissions</option>
                                @foreach ($listAccess as $access)

                                <option value="{{ $access }}" >{{ $access }}</option>
                            @endforeach
                            </select>
                            @error('permissions[]')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('menus.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
    $(".select2-multiple").select2();

    $("#icon").change(function(){
        var icon = $(this).val()
        $("#show-icon").addClass(icon)
    })

    $("#is_label").on("change", function() {
        if ($(this).prop("checked")) {
            $("#text-is-label").text("Yes");
        } else {
            $("#text-is-label").text("No");
        }
    });

    $("#name").keyup(function(){
        var name = $(this).val();
        name = name.toLowerCase();
        name = name.replace('module', '');
        name = name.replace(/[^a-zA-Z0-9]+/g, '-');
        $("#module").val(`module-${name}`)
    })
</script>
@endsection
