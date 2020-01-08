@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.clients')</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"><i class="fa fa-users"></i> @lang('site.clients')</li>
        </ol>
    </section>
    <section class="content">
        <!-- all clients -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.clients') <small>{{ $clients->total() }}</small></h3>
                <form action="{{ route('dashboard.clients.index') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="@lang('site.search')">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>

                            @if(auth()->user()->hasPermission('create_clients'))
                            <a class="btn btn-success" href="{{route('dashboard.clients.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a class="btn btn-success" href="#" disabled><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @if($clients->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.phone')</th>
                            <th>@lang('site.address')</th>
                            <th>@lang('site.add_order')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $clients as $index => $client )
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$client->name}}</td>
                            <td>{{implode($client->phone, '-')}}</td>
                            <td>{{$client->address}}</td>
                            <td>
                                @if(auth()->user()->hasPermission('create_orders'))
                                <a class="btn btn-primary btn-sm" href="{{route('dashboard.clients.orders.create', $client->id)}}">@lang('site.add_order')</a>
                                @else
                                <a class="btn btn-primary btn-sm" href="#" disabled>@lang('site.add_order')</a>
                                @endif
                            </td>

                            <td>

                                @if(auth()->user()->hasPermission('update_clients') )
                                <a class="btn btn-info btn-sm" href="{{route('dashboard.clients.edit', $client->id)}}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_clients'))
                                <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post" style="display:inline-block;">
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
                {{ $clients->appends(['search' => request('search')])->links() }}
                @else
                <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
</div>


@endsection
