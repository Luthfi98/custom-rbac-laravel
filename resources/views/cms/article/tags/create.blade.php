@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('tags-article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="name">Name :</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('tags-article.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                            <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')

@endsection
