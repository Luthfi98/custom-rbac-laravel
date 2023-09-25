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
                            </div>
                            <div>
                                @if ($general->canAccess('module-activity-user-create', true))
                                    <a href="{{ route('report-activity-user.create') }}" class="btn btn-primary btn-sm" title="Create"><span class="fa fa-plus"></span> {{__("Add Permission")}}</a>
                                @endif
                            </div>
                        </div>
                        <table class="display table" id="data-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>URL</th>
                                    <th>Description</th>
                                    <th width="105px">Action</th>
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
          ajax: {
                url: "{{ route('report-activity-user') }}",
                data: function (d) {
                    d.menu_id = $('#menu_id').val(); // Add the selected menu_id to the AJAX data
                }
            },
          columns: [
              {
            data: 'id',
            name: 'id',
            render: function(data, type, row, meta) {
                // Calculate the continuous index across all pages
                var continuousIndex = meta.row + meta.settings._iDisplayStart + 1;
                return continuousIndex;
            }
        },
              {data: 'user_id', name: 'user_id'},
              {data: 'url', name: 'url'},
              {data: 'description', name: 'description'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language: {
			paginate: {
			   next: '<i class="fa-solid fa-angle-right"></i>',
			  previous: '<i class="fa-solid fa-angle-left"></i>'
			},
		  },
      });

      $('#menu_id').on('change', function () {
          table.ajax.reload(); // Reload the table with the new filter value
      });
    });
  </script>



@endsection
