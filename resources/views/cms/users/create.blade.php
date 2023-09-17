@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="form-group mt-3">
                            <label for="fullname">Fullnme:</label>
                            <input type="text" name="fullname" id="fullname" class="form-control" required>
                            @error('fullname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group mt-3">
                                    <label for="password_confirmation">Re-Password:</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="">Assign Roles:</label>
                            @foreach ($roles as $item)
                                <div class="col-lg-2 col-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $item->id }}" id="roles-{{ $item->id }}">
                                        <label class="form-check-label" for="roles-{{ $item->id }}" id="text-is-label">{{ $item->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="mt-3">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
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
