@extends('layouts.cms')

@section('title'){{ $title }}@endsection

@php
switch ($article->status) {
    case 'Draft':
        $btn = 'warning';
        break;
    case 'Published':
        $btn = 'success';
        break;
    case 'Unpublished':
        $btn = 'danger';
        break;

    default:
        # code...
        break;
}
@endphp
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="post-details">
                    <h3 class="mb-2 text-black">{{ $article->title }}</h3>
                    <ul class="mb-4 post-meta d-flex flex-wrap">
                        <li class="post-author me-3">By {{ $article->creator->fullname }}</li>
                        <li class="post-date me-3"><i class="far fa-calendar-plus me-2"></i>{{ date('d M Y', strtotime($article->created_at)) }}</li>
                        <li class="post-author me-3">
                            Status :
                            <a href="javascript:void();;" class="text-{{$btn}} light">{{ $article->status }}</a>
                        </li>
                    </ul>
                    <img src="{{ url($article->image) }}" width="150px" alt="{{ $article->title }}" class="img-fluid mb-3 rounded">
                    {!! $article->content !!}
                    <div class="profile-skills mt-5 mb-5">
                        <h4 class="text-primary mb-2">Tags :</h4>
                        @foreach ($article->tag as $item)
                            <a href="javascript:void();;" class="btn btn-primary light btn-xs mb-1">{{ $item->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('data-article.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>

                    @if ($general->canAccess('module-data-article-update', true))
                        <a href="{{ route('data-article.edit', $article->id) }}" class="btn btn-primary" title="Create"> {{__("Update Article")}}</a>
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection
