@extends('layouts.cms')

@section('title'){{ $title }}@endsection



@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $activity->description }}</h4>
                </div>
                <div class="card-body">
                    <table class="table" width="100%">
                        <tr>
                            <th width="29%">User</th>
                            <th width="1%">:</th>
                            <td>{{ $activity->user->fullname }}</td>
                        </tr>
                        <tr>
                            <th width="29%">IP</th>
                            <th width="1%">:</th>
                            <td>{{ $activity->ip }}</td>
                        </tr>
                        <tr>
                            <th width="29%">URL</th>
                            <th width="1%">:</th>
                            <td>{{ $activity->url }}</td>
                        </tr>
                        <tr>
                            <th width="29%">Date</th>
                            <th width="1%">:</th>
                            <td>{{ date('d-m-Y H:i:s', strtotime($activity->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th width="29%">Data</th>
                            <th width="1%">:</th>
                            <td>
                                {!! $data !!}
                                {{-- @php
                                    $data = json_decode($activity->data);
                                    // dd($data);
                                @endphp
                                <ul>
                                    @foreach ($data as $key => $value)
                                    @if (is_array($value))
                                        <li>
                                            {!! '<b>'.$key.'</b> : '!!}
                                            <ul>
                                                @foreach ($value as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </li>

                                    @else
                                        <li>
                                            {!! '<b>'.$key.'</b> : '.$value !!}
                                        </li>

                                    @endif

                                    @endforeach --}}
                                </ul>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('report-activity-user') }}" class="btn btn-secondary">{{ __('Back') }}</a>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

@endsection
