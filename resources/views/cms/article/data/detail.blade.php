@extends('layouts.cms')

@section('title'){{ $title }}@endsection


@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6">
                        <!-- Tab panes -->
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                 <img class="img-fluid rounded  " src="{{ url($product->image) }}" alt="">
                          </div>
                        </div>
                    </div>
                    <!--Tab slider End-->
                    <div class="col-xl-9 col-lg-6 col-md-6 col-sm-12">
                        <div class="product-detail-content">
                            <!--Product details-->
                            <div class="new-arrival-content pr">
                                <h3>{{ $product->name }}</h3>
                                {{-- <div class="comment-review star-rating d-flex">
                                    <ul>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <span class="review-text ms-3">(34 reviews) / </span><a class="product-review" href="#"  data-bs-toggle="modal" data-bs-target="#reviewModal">Write a review?</a>
                                </div> --}}
                                <div class="d-table mb-2">
                                    <p class="price float-start d-block">Rp. {{ number_format($product->price,2,',','.') }}</p>
                                </div>
                                <p>Category: <span class="badge badge-sm badge-success light">{{ $product->category?->name }}</span></p>
                                <p>Brand: <span class="badge badge-sm badge-success light">{{ $product->brand?->name }}</span></p>

                                <p>Stock: <span class="badge badge-sm badge-success light">{{ number_format($product->qty,0,',','.').' '.$product->unit?->name }}</span></p>
                                <p class="text-content">{!! $product->description !!}</p>
                                <div class="d-flex align-items-end flex-wrap mt-4">
                                    <a class="btn btn-secondary" href="{{ route('pos-products.index') }}"><span class="fa fa-arrow-left"></span> Kembali</a> &nbsp;
                                    <a class="btn btn-primary" href="{{ route('pos-products.edit', $product->id) }}"><span class="fa fa-pencil"></span> Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
