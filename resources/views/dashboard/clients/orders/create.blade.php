@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.clients')</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-users"></i> @lang('site.clients')</a></li>
            <li><i class="fa fa-plus"></i> @lang('site.add')</li>
        </ol>
    </section>
    <section class="content">
        <!-- add order -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add_order')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div class="row">
                    <!-- Categories And Their Products List -->
                    <div class="col-md-6">
                        <h4>@lang('site.categories')</h4>

                        @if( count($categories) > 0 )

                        <div class="panel-group">
                            @foreach( $categories as $category )
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#{{ str_replace( ' ', '-', $category->name ) }}">{{ $category->name }}</a>
                                    </h4>
                                </div>
                                <div id="{{ str_replace( ' ', '-', $category->name ) }}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        @if( $category->products()->count() > 0 )

                                        <!-- Category Products Table -->
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>@lang('site.name')</th>
                                                    <th>@lang('site.stock')</th>
                                                    <th>@lang('site.price')</th>
                                                    <th>@lang('site.add')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach( $category->products as $product )

                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ $product->sale_price }}</td>
                                                    <td><a  href="#"
                                                            id="product-{{ $product->id }}"
                                                            class="add-product-btn btn btn-success btn-sm"
                                                            data-id="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-price="{{ $product->sale_price }}">
                                                            <i class="fa fa-plus"></i></a></td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                        <!-- /.Category Products Table -->

                                        @else

                                        <h2>@lang('site.no_data_found')</h2>

                                        @endif

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @else

                        <h2>@lang('site.no_data_found')</h2>

                        @endif

                    </div>
                    <!-- /.Categories And Their Products List -->
                    <!-- Orders List -->
                    <div class="col-md-6">
                        <h4>@lang('site.orders')</h4>
                        <form id="add_order" action="{{ route('dashboard.clients.orders.store', $client->id) }}" method="post">
                            @csrf

                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>@lang('site.product')</td>
                                        <td>@lang('site.quantity')</td>
                                        <td>@lang('site.price')</td>
                                    </tr>
                                </thead>
                                <tbody class="order-list"></tbody>
                            </table>

                            <h4>@lang('site.total'): <span id="total-price">0</span></h4>

                            <div class="form-group">
                                <button id="add-order-form-btn" class="btn btn-primary form-control disabled" type="submit"><i class="fa fa-plus"></i> @lang('site.add_order')</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.Orders List -->
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>

@endsection
