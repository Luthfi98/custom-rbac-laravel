@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="nestable">
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach ($menus as $menu)
                                <li class="dd-item" data-id="{{ $menu->id }}">
                                    <div class="dd-handle"><span class="{{ $menu->icon }}"></span> {{ $menu->name }}
                                        {{-- <div class="edit-button-container">
                                            <button class="btn btn-sm btn-primary" data-id="{{ $menu->id }}">Edit</button>
                                        </div> --}}
                                    </div>
                                    @if ($menu->child->count() > 0)
                                        <ol class="dd-list">
                                            @foreach ($menu->child as $childMenu)
                                                <li class="dd-item" data-id="{{ $childMenu->id }}">
                                                    <div class="dd-handle"><span class="{{ $childMenu->icon }}"></span> {{ $childMenu->name }}</div>
                                                    @if ($childMenu->child->count() > 0)
                                                        <ol class="dd-list">
                                                            @foreach ($childMenu->child as $grandchildMenu)
                                                                <li class="dd-item" data-id="{{ $grandchildMenu->id }}">
                                                                    <div class="dd-handle"><span class="{{ $grandchildMenu->icon }}"></span> {{ $grandchildMenu->name }}</div>
                                                                    <!-- Repeat this pattern for additional levels -->
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </li>
                            @endforeach
                        </ol>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<!-- Nestable -->
<link href="{{ asset('cms/vendor/nestable2/css/jquery.nestable.min.css') }}" rel="stylesheet">
{{-- <style>
    .edit-button-container {
    float: right;
}
</style> --}}
@endsection


@section('js')
<!-- Nestable -->
<script src="{{ asset('cms/vendor/nestable2/js/jquery.nestable.min.js') }}"></script>
<script>
     $("#nestable").nestable({
            group: 1,
            maxDepth: 3
        }).on('change', function() {
    // Mengumpulkan data tata letak yang diperbarui
    var updatedData = $(this).nestable('serialize');
    var formData = {
        data: updatedData,
        _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
    };
    $.ajax({
        type: 'POST',
        url: '{{ route("menus.sorting.store") }}',
        data: formData,
        // contentType: 'application/json',
        success: function(response) {
            toastSuccess(response.message)

        },
        error: function(error) {
            // Callback jika terjadi kesalahan saat pengiriman
            console.error('Terjadi kesalahan:', error);
        }
    });
});
</script>
@endsection
