<!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('cms/vendor/global/global.min.js') }}"></script>
    {{-- SweetAlert --}}
    <script src="{{ asset('cms/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('cms/vendor/toastr/js/toastr.min.js') }}"></script>
	<script src="{{ asset('cms/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('cms/js/custom.js') }}"></script>
	<script src="{{ asset('cms/js/deznav-init.js') }}"></script>
	{{-- <script src="{{ asset('cms/js/demo.js') }}"></script> --}}
    <script src="{{ asset('cms/js/styleSwitcher.js') }}"></script>
	<script src="https://kit.fontawesome.com/527602f9c4.js" crossorigin="anonymous"></script>
    <script>
        function swalSuccess(msg){
            swal("Sucessfully", msg, "success")
        }

        function swalWarning(msg){
            swal("Warning!", msg, "warning")
        }

        function swalConfirm(id){
            swal({
                title: "Are you sure to delete?",
                text: "You will not be able to recover!!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value) {
                    const form = $('#delete-form-' + id);
                    form.submit();
                } else {
                    toastInfo('Calceled Deleted Data')
                }
            })
        }
        function showConfirmChangeRole(id){
            swal({
                title: "Change Role?",
                text: "Access will be adjusted to the selected role!!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value) {
                    const form = $('#role-form-' + id);
                    form.submit();
                } else {
                    toastInfo('Calceled Change Role')
                }
            })
        }

        function toastSuccess(msg, delay = '300')
        {
            toastr.success(msg, "Notification", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: delay,
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function toastInfo(msg, delay = '300')
        {
            toastr.info(msg, "Notification", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: delay,
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function toastWarning(msg, delay = '300')
        {
            toastr.warning(msg, "Notification", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: delay,
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function toastDanger(msg, delay = '300')
        {
            toastr.danger(msg, "Notification", {
                positionClass: "toast-top-right",
                timeOut: 5e3,
                closeButton: !0,
                debug: !1,
                newestOnTop: !0,
                progressBar: !0,
                preventDuplicates: !0,
                onclick: null,
                showDuration: delay,
                hideDuration: "1000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                tapToDismiss: !1
            })
        }

        function showConfirm(id)
        {
            // const url = $(_data).attr('url')
            // console.log(url)
            swalConfirm(id)
        }

        var handleThemeMode = function() {

            $('.dz-theme-mode').on('click',function(){
                $(this).toggleClass('active');

                if($(this).hasClass('active')){
                    var theme = 'dark';

                    $(`#icon-light`).removeAttr('hidden')
                    $(`#icon-dark`).attr('hidden', true)

                }else{
                    var theme = 'light';
                    $(`#icon-dark`).removeAttr('hidden')
                    $(`#icon-light`).attr('hidden', true)
                }

                var formData = {
                    theme: theme,
                    _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
                };

                $.ajax({
                    url:"{{ route('profile.preference') }}",
                    data:formData,
                    type:"POST",
                    dataType:"JSON",
                    success:function(response)
                    {
                        $('body').attr('data-theme-version',theme);
                        // $('.dz-theme-mode').removeClass('active')

                    }
                })
            });


        }
    </script>
    @yield('js')
