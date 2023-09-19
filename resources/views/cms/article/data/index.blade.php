@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="default-tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" onclick="changeTab('all')" data-bs-toggle="tab" href="#all"><i class="la la-list me-2"></i> All Article</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-success" data-bs-toggle="tab" onclick="changeTab('published')" href="#published"><i class="la la-check me-2 text-success"></i> Published Article</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning" data-bs-toggle="tab" onclick="changeTab('unpublished')" href="#unpublished"><i class="la la-times me-2 text-warning"></i> Unpublished Article</a>
                            </li>
                            @if ($general->canAccess('module-data-article-trash', true))
                                <li class="nav-item">
                                    <a class="nav-link text-danger" data-bs-toggle="tab" onclick="changeTab('trashed')" href="#trashed"><i class="la la-trash me-2 text-danger"></i> Trashed Article</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                <div class="pt-4">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>

                                            </div>
                                            <div>
                                                @if ($general->canAccess('module-data-article-create', true))
                                                    <a href="{{ route('data-article.create') }}" class="btn btn-primary btn-sm" title="Create"><span class="fa fa-plus"></span> {{__("Add Article")}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <table class="display table table-hover" id="data-table-all" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th width="10%">Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                    <th width="105px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="published">
                                <div class="pt-4">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>

                                            </div>
                                            <div>
                                                @if ($general->canAccess('module-data-article-create', true))
                                                    <a href="{{ route('data-article.create') }}" class="btn btn-primary btn-sm" title="Create"><span class="fa fa-plus"></span> {{__("Add Article")}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <table class="display table table-hover" id="data-table-published" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th width="10%">Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                    <th width="105px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="unpublished">
                                <div class="pt-4">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>

                                            </div>
                                            <div>
                                                @if ($general->canAccess('module-data-article-create', true))
                                                    <a href="{{ route('data-article.create') }}" class="btn btn-primary btn-sm" title="Create"><span class="fa fa-plus"></span> {{__("Add Article")}}</a>
                                                @endif
                                            </div>
                                        </div>
                                        <table class="display table table-hover" id="data-table-unpublished" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
                                                    <th width="10%">Image</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                    <th width="105px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($general->canAccess('module-data-article-trash', true))
                                <div class="tab-pane fade" id="trashed">
                                    <div class="pt-4">
                                        <div class="table-responsive">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div>

                                                </div>
                                                <div>
                                                    @if ($general->canAccess('module-data-article-create', true))
                                                        <a href="{{ route('data-article.create') }}" class="btn btn-primary btn-sm" title="Create"><span class="fa fa-plus"></span> {{__("Add Article")}}</a>
                                                    @endif
                                                    @if ($general->canAccess('module-data-article-restore', true))
                                                        <a href="#" class="btn btn-success btn-sm proccess" data-type="restore" title="Restore"><span class="fa fa-trash-arrow-up"></span> {{__("Restore Selected Data")}}</a>
                                                    @endif
                                                    @if ($general->canAccess('module-data-article-delete', true))
                                                        <a href="#" class="btn btn-danger btn-sm proccess" data-type="delete" title="Delete"><span class="fa fa-times"></span> {{__("Delete Selected Data")}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <table class="display table table-hover" id="data-table-trashed" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" name="all" value="all" id="select-all"></th>
                                                        <th width="1%">No</th>
                                                        <th width="10%">Image</th>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
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
<style>
    #data-table tbody tr {
    cursor: pointer;
}
</style>
@endsection
@section('js')
<!-- Datatable -->
<script src="{{ asset('cms/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('cms/js/plugins-init/datatables.init.js') }}"></script>


<script type="text/javascript">

    $(document).ready(function(){
        changeTab('all')
    })

    function changeTab(filter)
    {
        var columns = [
            {
                data: 'id',
                name: 'id',
                render: function(data, type, row, meta) {
                    // Calculate the continuous index across all pages
                    var continuousIndex = meta.row + meta.settings._iDisplayStart + 1;
                    return continuousIndex;
                }
            },
            { data: 'image', name: 'image'},
            { data: 'title', name: 'title' },
            { data: 'category_name', name: 'category_name', orderable: false, searchable: false },
            { data: 'status', name: 'status' },
        ];

        if (filter === 'trashed') {
            columns.unshift({ data: 'select_checkbox', name: 'select_checkbox', orderable: false, searchable: false });
        }else{
            columns.push({ data: 'action', name: 'action', orderable: false, searchable: false });
        }
        let table = $(`#data-table-${filter}`).DataTable({
          processing: true,
          serverSide: true,
          destroy:true,
          ajax: {
            url:"{{ route('data-article.index') }}",
            data:function (d) {
                d.filter = filter;
            }
        },
          columns: columns,
          language: {
			paginate: {
			   next: '<i class="fa-solid fa-angle-right"></i>',
			  previous: '<i class="fa-solid fa-angle-left"></i>'
			},
		  },
      });

      $(`#data-table-${filter} tbody`).on('click', 'tr td:not(:first-child):not(:last-child)', function () {
            var data = table.row($(this).closest('tr')).data();
            if (data) {
                var url = "{{ route('data-article.show', ':id') }}".replace(':id', data.id);
                window.open(url, '_blank');
            }
        });
    }


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
          var selectedArticles = [];
          $('.selected:checked').each(function() {
              selectedArticles.push($(this).val());
          });
          if(!selectedArticles.length)
          {
            toastWarning('Data Not Selected');
          }else{

              var formData = {
                  products: selectedArticles,
                  type: $(this).data('type'),
                  _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
              };

              $.ajax({
                  url: '{{ route("data-article.trashed.store") }}',
                  type: 'POST',
                  data: formData,
                  success: function(response, textStatus, jqXHR) {

                      toastSuccess(response.message)
                      changeTab('trashed')
                  },
                  error: function(error) {
                      // Handle error response from the server
                      toastWarning("Access Denied");
                  }
              });
          }
      });

    $(function () {



    //   $('#data-table tbody').on('click', 'tr td', function () {
    //         var data = table.row(this).data();
    //         if (data) {
    //             var url = "{{ route('data-article.show', ':id') }}".replace(':id', data.id);
    //             window.open(url, '_blank');
    //         }
    //     });

    });
  </script>
@endsection
