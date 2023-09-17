@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group mt-3">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $role->description }}</textarea>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                            <button type="submit" class="btn btn-primary">{{__('Update')}}</button>
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
