@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.products')</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"><i class="fa fa-book"></i> @lang('site.products')</li>
        </ol>
    </section>
    <section class="content">
        <!-- all products -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.products') <small>{{ $products->total() }}</small></h3>
                <form action="{{ route('dashboard.products.index') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="@lang('site.search')">
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-control">
                                <option value="">@lang('site.all_categories')</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{ $category->id == request('category_id') ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>

                            @if(auth()->user()->hasPermission('create_products'))
                            <a class="btn btn-success" href="{{route('dashboard.products.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a class="btn btn-success" href="#" disabled><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @if($products->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.description')</th>
                            <th>@lang('site.category')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.purchase_price')</th>
                            <th>@lang('site.sale_price')</th>
                            <th>@lang('site.profit_percent') %</th>
                            <th>@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $products as $index => $product )
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$product->name}}</td>
                            <td>{!! $product->description !!}</td>
                            <td>{{ $product->category->name }}</td>
                            @if(! is_null($product->image))
                            <td>
                                <img src="{{ $product->image_path }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 64px; height: 64px">
                            </td>
                            @else
                            <td>
                                <img src="{{ asset('uploads/users/default.png') }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 64px; height: 64px">
                            </td>
                            @endif
                            <td>{{$product->purchase_price}}</td>
                            <td>{{$product->sale_price}}</td>
                            <td>{{$product->profit_percent}} %</td>
                            <td>

                                @if(auth()->user()->hasPermission('update_products') )
                                <a class="btn btn-info btn-sm" href="{{route('dashboard.products.edit', $product->id)}}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_products'))
                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post" style="display:inline-block;">
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
                {{ $products->appends(['search' => request('search'), 'category_id' => request('category_id')])->links() }}
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
