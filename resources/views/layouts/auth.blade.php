@php
    $general = new GeneralHelper;

@endphp
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    @include('partials.header')

    @include('partials.css')


</head>

<body class="vh-100">
	<div class="page-wraper">

		<!-- Content -->
		<div class="browse-job login-style3">
			<!-- Coming Soon -->
            @yield('content')
			<!-- Full Blog Page Contant -->
		</div>
		<!-- Content END-->
	</div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
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
