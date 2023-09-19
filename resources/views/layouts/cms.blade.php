@php
    $general = new GeneralHelper;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.header')

    @include('partials.css')



</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div>
			<img src="{{ asset('cms/images/pre.gif') }} " alt="">
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('partials.navbar')

        @include('partials.sidebar')

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <!--**********************************
            Content body end
        ***********************************-->
        @include('partials.footer')

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    @include('partials.js')

    @if(session('success'))
        <script>
            toastSuccess("{{ session('success') }}");
        </script>
    @elseif (session('warning'))
        <script>
            toastWarning("{{ session('warning') }}");
        </script>
    @endif
</body>
</html>
