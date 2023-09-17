@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-4">
        <div class="clearfix">
            <div class="card card-bx profile-card author-profile m-b30">
                <div class="card-body">
                    <div class="p-5">
                        <div class="author-profile">
                            <div class="author-media">
                                <img src="{{ $user->image ? url($user->image) : '' }}" alt="" id="preview">
                                <button class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="update">
                                    <i class="fa fa-camera"></i>
                                </button>
                            </div>
                            <div class="author-info">
                                <h6 class="title"> {{ $user->fullname }} </h6>
                                <span>{{ $user->role? $user->role->name : $currentRole->name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-list">
                        <ul>
                            <li><span>Username</span><span> {{ $user->username }} </span></li>
                            <li><span>Fullname</span><span> {{ $user->fullname }} </span></li>
                            <li><span>Email</span><span> {{ $user->email }} </span></li>
                            <li><span>Phone</span><span> {{ $user->phone }} </span></li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="input-group mb-3">
                        <div class="form-control text-center bg-white">Change Role</div>
                    </div>
                    <div class="input-group">
                    </div>
                    <div class="row">
                        @foreach ($user->roles as $role)
                        <div class="col-6">

                            @php
                            $select = $currentRole->id == $role->role->id ? 'bg-primary text-white disabled' : 'bg-white text-primary btn-outline-primary';
                            @endphp
                            <form id="role-form-{{$role->role->id}}" action="{{route('profile.change', $role->role->id)}}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <button class="btn btn-block {{$select}}" type="button" onclick="showConfirmChangeRole({{$role->role->id}})" title="Change to Role {{ $role->role->name }}">
                                {{ $role->role->name }}
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8">
        <div class="card profile-card card-bx m-b30">
            <div class="card-header">
                <h6 class="title">Account setup</h6>
            </div>
            <form class="profile-form" method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Fullname</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" value="{{ $user->fullname }}">
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}">
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="col-sm-6 m-b30">
                            <label class="form-label">Default Role</label>
                            <select class="default-select form-control" name="default_role" id="default_role">
                                <option  data-display="Select">Please select</option>
                                @foreach ($user->roles as $role)
                                    <option value="{{ $role->role->id }}" {{ $user->default_role == $role->role->id ? 'selected' : '' }}>{{ $role->role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <input type="file" class="update-flie" id="image" name="image" hidden>

                <div class="card-footer">
                    <button class="btn btn-primary">UPDATE</button>
                    <a href="page-register.html" class="btn-link">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(".upload-link").click(function(){
        $('#image').click();
        // console.log(input.files,input.files[0])
    })

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
