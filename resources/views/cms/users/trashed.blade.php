@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <!-- Add your buttons here -->
                            </div>
                            <div>
                                @if ($general->canAccess('trashed-user-restore', true))
                                    <a href="#" class="btn btn-success btn-sm proccess" data-type="restore" title="Restore"><span class="fa fa-trash-arrow-up"></span> {{__("Restore Selected Data")}}</a>
                                @endif
                                @if ($general->canAccess('trashed-user-delete', true))
                                    <a href="#" class="btn btn-danger btn-sm proccess" data-type="delete" title="Delete"><span class="fa fa-times"></span> {{__("Delete Selected Data")}}</a>
                                @endif
                            </div>
                        </div>
                        <table class="display table" id="data-table" width="100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="all" value="all" id="select-all"></th>
                                    <th>No</th>
                                    <th>Fullname</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Deleted At</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
<!-- Datatable -->
<link href="{{ asset('cms/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('cms/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet"> --}}
@endsection
@section('js')
<!-- Datatable -->
<script src="{{ asset('cms/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('cms/js/plugins-init/datatables.init.js') }}"></script>


<script type="text/javascript">
    $(function () {

      var table = $('#data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('users.trashed') }}",
          columns: [
              {data: 'select_checkbox', name: 'select_checkbox', orderable: false, searchable: false},
              {
            data: 'id',
            name: 'id',
            render: function(data, type, row, meta) {
                // Calculate the continuous index across all pages
                var continuousIndex = meta.row + meta.settings._iDisplayStart + 1;
                return continuousIndex;
            }
        },
              {data: 'fullname', name: 'fullname'},
              {data: 'username', name: 'username'},
              {data: 'email', name: 'email'},
              {data: 'phone', name: 'phone'},
              {data: 'deleted_at', name: 'deleted_at'},
          ],
          language: {
			paginate: {
			   next: '<i class="fa-solid fa-angle-right"></i>',
			  previous: '<i class="fa-solid fa-angle-left"></i>'
			},
		  },
      });

      $('#select-all').on('change', function() {
          $('.selected').prop('checked', $(this).prop('checked'));
      });

      // Handle individual checkboxes
      $('body').on('change', '.selected', function() {
          if ($('.selected:checked').length === $('.selected').length) {
              $('#select-all').prop('checked', true);
          } else {
              $('#select-all').prop('checked', false);
          }
      });

      $('.proccess').on('click', function() {
          var selectedRow = [];
          $('.selected:checked').each(function() {
              selectedRow.push($(this).val());
          });
          // console.log(selectedRow);
          var formData = {
              users: selectedRow,
              type: $(this).data('type'),
              _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
          };

          console.log(formData);

          $.ajax({
              url: '{{ route("users.trashed.store") }}',
              type: 'POST',
              data: formData,
              success: function(response) {
                  toastSuccess(response.message)
                  table.ajax.reload()
              },
              error: function(error) {
                  // Handle error response from the server
                  console.error('Error submitting data:', error);
              }
          });
      });

    });
  </script>
@endsection
