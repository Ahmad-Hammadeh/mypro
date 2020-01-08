@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.orders')</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"><i class="fa fa-shopping-cart"></i> @lang('site.orders')</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <!-- all orders -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.orders') <small>{{ $orders->total() }}</small></h3>
                        <form action="{{ route('dashboard.orders.index') }}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="@lang('site.search')">
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        @if($orders->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.client_name')</th>
                                    <th>@lang('site.total_price')</th>
                                    <th>@lang('site.total_price')</th>
                                    <!-- <th>@lang('site.status')</th> -->
                                    <th>@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $orders as $index => $order )
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$order->client->name}}</td>
                                    <td>{{$order->total_price}}</td>
                                    {{-- <td>
                                        <button
                                            class="order-status-btn btn btn-{{ $order->status === 'approved' ? 'danger': 'success' }}"
                                            data-status="@lang( 'site.' . $order->status )"
                                            data-url="{{ route('dashboard.order.update_status') }}"
                                            data-method="put"
                                            data-available-status='[ "@lang('site.processing')", "@lang('site.approved')", "@lang('site.refused')" ]'
                                            >
                                            {{ $order->status === 'approved' ? '@lang( 'site.refuse' ): '@lang( 'site.approve' )' }}
                                            </button>
                                    </td> --}}
                                    <td>{{$order->created_at->toFormattedDateString()}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm order-products-show"
                                                data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                        >
                                        <i class="fa fa-list"></i> @lang('site.show')
                                        </button>

                                        @if(auth()->user()->hasPermission('update_orders') )
                                        <a class="btn btn-info btn-sm" href="{{route('dashboard.orders.edit', $order->id)}}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-info btn-sm" href="#" disabled><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif

                                        @if(auth()->user()->hasPermission('delete_orders'))
                                        <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="post" style="display:inline-block;">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        </form>
                                        @else
                                        <a class="btn btn-danger btn-sm" href="#" disabled>@lang('site.delete')</a>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->appends(['search' => request('search')])->links() }}
                        @else
                        <h2>@lang('site.no_data_found')</h2>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                </div>
            <!-- /.col -->
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.show_products') <small>5</small></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- Here Order Product Will Be Shown -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>


@endsection
