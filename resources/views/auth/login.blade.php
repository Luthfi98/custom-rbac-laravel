@extends('layouts.auth')

@section('title'){{ $title }}@endsection



@section('content')
<div class="bg-img-fix overflow-hidden" style="background:#fff url({{ asset('cms/images/background/bg6.jpg') }}); height: 100vh;">
    <div class="row gx-0">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white ">
            <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 653px;" tabindex="0">
                <div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                    <div class="login-form style-2">
                        <div class="card-body text-center">
                            <div class="logo-header text-center">

                                <a href="{{ route('login') }}" class="text-center"><img src="{{ asset($general->getSetting()->logo) }}" alt="" width="100px" class=""></a>
                            </div>

                            <form action="{{ route('login.do') }}" method="POST" class=" dz-form pb-3">
                                @csrf
                                <h3 class="form-title m-t0">Login Page</h3>
                                <div class="dz-separator-outer m-b5">
                                    <div class="dz-separator bg-primary style-liner"></div>
                                </div>
                                <p>Enter your e-mail address and your password. </p>
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" name="email" value="" placeholder="Email">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password" value="">
                                </div>
                                <div class="form-group text-left mb-5 forget-main">
                                    <button type="submit" class="btn btn-block btn-primary">Sign Me In</button>

                                    <div class="row jsutify-content-between">
                                        <div class="col-6">

                                            <span class="form-check d-inline-block">
                                                <input type="checkbox" class="form-check-input" id="check1" name="example1">
                                                <label class="form-check-label" for="check1">Remember me</label>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                <div class="dz-social ">
                                    <h5 class="">Doesn't Have Account?</h5>
                                    <a  href="{{ route('register') }}" class="btn btn-primary btn-sm">Register Now</a>
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
