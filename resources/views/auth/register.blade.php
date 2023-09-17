@extends('layouts.auth')

@section('title'){{ $title }}@endsection



@section('content')
<div class="bg-img-fix overflow-hidden" style="background:#fff url({{ asset('cms/images/background/bg6.jpg') }}); height: 100vh;">
    <div class="row gx-0">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white ">
            <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 653px;" tabindex="0">
                <div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                    <div class="login-form style-2">
                        <div class="card-body">
                            <div class="logo-header">
                                <a href="{{ route('register') }}" class="logo"><img src="{{ asset('cms/images/logo/logo-full.png') }}" alt="" class="width-230 light-logo"></a>
                                <a href="{{ route('register') }}" class="logo"><img src="{{ asset('cms/images/logo/logofull-white.png') }}" alt="" class="width-230 dark-logo"></a>
                            </div>
                            <form class="dz-form py-2" method="POST" action="{{ route('register.do') }}">
                                @csrf
                                <h3 class="form-title">Sign Up</h3>
                                <div class="dz-separator-outer m-b5">
                                    <div class="dz-separator bg-primary style-liner"></div>
                                </div>
                                <p>Enter your personal details below: </p>
                                <div class="form-group mt-3">
                                    <input name="fullname" required="" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="form-group mt-3">
                                    <input name="username" required="" class="form-control" placeholder="User Name" value="" type="text">
                                </div>
                                <div class="form-group mt-3">
                                    <input name="email" required="" class="form-control" placeholder="Email Address" type="email">
                                </div>

                                <div class="form-group mt-3">
                                    <input name="phone" required="" class="form-control" placeholder="Phone Number" type="text">
                                </div>

                                <div class="form-group mt-3">
                                    <input name="password" required="" class="form-control" placeholder="Password" type="password">
                                </div>
                                <div class="form-group mt-3 mb-3">
                                    <input name="password_confirmation" required="" class="form-control" placeholder="Re-type Your Password" type="password">
                                </div>
                                <div class="mb-3">
                                    <span class="form-check float-start me-2 ">
                                        <input type="checkbox" class="form-check-input" id="check2" name="example1">
                                        <label class="form-check-label d-unset" for="check2">I agree to the</label>
                                    </span>
                                    <label ><a href="page-login.html#">Terms of Service </a>&amp; <a href="page-login.html#">Privacy Policy</a></label>
                                </div>
                                <div class="form-group clearfix text-left">
                                    <a href="{{ route('login') }}" class="btn btn-secondary">Back</a>
                                    <button class="btn btn-primary float-end">Submit</button>
                                </div>
                            </form>
                        </div>
                            <div class="card-footer">
                                <div class=" bottom-footer clearfix m-t10 m-b20 row text-center">
                                <div class="col-lg-12 text-center">
                                    <span> © Copyright by <span class="heart"></span>
                                    <a href="javascript:void(0);">DexignZone </a> All rights reserved.</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
                    <div class="mCSB_draggerContainer">
                    <div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 0px; display: block; height: 652px; max-height: 643px; top: 0px;">
                    <div class="mCSB_dragger_bar" style="line-height: 0px;"></div><div class="mCSB_draggerRail"></div></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
