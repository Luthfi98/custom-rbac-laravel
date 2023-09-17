@extends('layouts.cms')

@section('title'){{ $title }}@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group mt-3">
                    <label for="role"><b>Name </b>:</label>
                    <span> {{ $role->name }} </span>
                </div>
                <div class="form-group mt-3">
                    <label for="role"><b>Role Description</b>:</label>
                    <span> {{ $role->description }} </span>
                </div>
                <hr>
                <label for="">Assigned for Permissions</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="all" value="all" id="select-all">
                    <label class="form-check-label" for="select-all" id="text-is-label">Select All</label>
                </div>
                <form action="{{ route('roles.storePermission') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $role->id }}">
                    <ul>
                        @php
                            $permissionsChunks = array_chunk($menus->toArray(), ceil(count($menus) / 2));
                        @endphp

                        <div class="row">
                            @foreach ($permissionsChunks as $chunk)
                            <div class="col-md-3">
                                @foreach ($chunk as $menu)
                                    <li>
                                        <label for="">{{ $menu['name'] }}</label>
                                        <ul>
                                            @foreach ($menu['permissions'] as $permission)
                                                <li>
                                                    @php
                                                        $checked = $role->permissions->contains('permission_id', $permission['id']) ? 'checked' : '';
                                                    @endphp
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input permission" {{ $checked }} type="checkbox" name="permissions[]" value="{{ $permission['id'] }}" id="permissions-{{ $permission['id'] }}">
                                                        <label class="form-check-label" for="permissions-{{ $permission['id'] }}" id="text-is-label">{{ $permission['name'] }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                            {{-- Child permissions --}}
                                            @foreach ($menu['child'] as $childMenu)
                                                <li>
                                                    <label for="">{{ $childMenu['name'] }}</label>
                                                    <ul class="submenu">
                                                        @foreach ($childMenu['permissions'] as $childPermission)
                                                            <li>
                                                                @php
                                                                    $childChecked = $role->permissions->contains('permission_id', $childPermission['id']) ? 'checked' : '';
                                                                @endphp
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input permission" {{ $childChecked }} type="checkbox" name="permissions[]" value="{{ $childPermission['id'] }}" id="permissions-{{ $childPermission['id'] }}">
                                                                    <label class="form-check-label" for="permissions-{{ $childPermission['id'] }}" id="text-is-label">{{ $childPermission['name'] }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        {{-- Grandchild permissions --}}
                                                        @foreach ($childMenu['child'] as $grandchildMenu)
                                                            <li>
                                                                <label for="">{{ $grandchildMenu['name'] }}</label>
                                                                <ul class="subsubmenu">
                                                                    @foreach ($grandchildMenu['permissions'] as $grandchildPermission)
                                                                        <li>
                                                                            @php
                                                                                $grandchildChecked = $role->permissions->contains('permission_id', $grandchildPermission['id']) ? 'checked' : '';
                                                                            @endphp
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input permission" {{ $grandchildChecked }} type="checkbox" name="permissions[]" value="{{ $grandchildPermission['id'] }}" id="permissions-{{ $grandchildPermission['id'] }}">
                                                                                <label class="form-check-label" for="permissions-{{ $grandchildPermission['id'] }}" id="text-is-label">{{ $grandchildPermission['name'] }}</label>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </div>
                        @endforeach

                        </div>


                    </ul>
                    <hr>
                    <div class="row mt-3">
                        <label for="">Assigned For User:</label>
                        @foreach ($users as $item)
                            <div class="col-lg-2 col-6">
                                @php
                                    $checked = $role->users->contains('user_id', $item['id']) ? 'checked' : '';
                                @endphp
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" {{ $checked }} name="users[]" value="{{ $item->id }}" id="users-{{ $item->id }}">
                                    <label class="form-check-label" for="users-{{ $item->id }}" id="text-is-label">{{ $item->fullname }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('roles.index') }}" class="btn mt-3 btn-secondary"> {{ __("Back") }} </a>
                    <button class="mt-3 btn btn-primary" type="submit"> {{ __("Save") }} </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script>
    checkedAll()
    $('#select-all').on('change', function() {
        $('.permission').prop('checked', $(this).prop('checked'));
    });

    $('body').on('change', '.permission', function() {
        checkedAll()
      });

      function checkedAll()
      {
            if ($('.permission:checked').length === $('.permission').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
      }

</script>
@endsection
