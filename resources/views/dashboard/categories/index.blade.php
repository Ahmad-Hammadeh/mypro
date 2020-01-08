@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.categories')</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"><i class="fa fa-list"></i> @lang('site.categories')</li>
        </ol>
    </section>
    <section class="content">
        <!-- all categories -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.categories') <small>{{ $categories->total() }}</small></h3>
                <form action="{{ route('dashboard.categories.index') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="@lang('site.search')">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>

                            @if(auth()->user()->hasPermission('create_categories'))
                            <a class="btn btn-success" href="{{route('dashboard.categories.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a class="btn btn-success" href="#" disabled><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @if($categories->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.products_count')</th>
                            <th>@lang('site.related_products')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $categories as $index => $category )
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->products->count()}}</td>
                            <td><a class="btn btn-info btn-sm" href="{{route('dashboard.products.index', ['category_id' => $category->id])}}">@lang('site.related_products')</a></th>
                            <td>

                                @if(auth()->user()->hasPermission('update_categories') )
                                <a class="btn btn-info btn-sm" href="{{route('dashboard.categories.edit', $category->id)}}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_categories'))
                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post" style="display:inline-block;">
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
                {{ $categories->appends(['search' => request('search')])->links() }}
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
