@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.products')</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.products.index')}}"><i class="fa fa-book"></i> @lang('site.products')</a></li>
            <li><i class="fa fa-plus"></i> @lang('site.add')</li>
        </ol>
    </section>
    <section class="content">
        <!-- add product -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @foreach(config('translatable.locales') as $locale)

                    <div class="form-group">
                        <label for="name">@lang('site.' . $locale . '.name')</label>
                        <input class="form-control" type="text" name="{{ $locale }}[name]" id="name" value="{{ old($locale . '.name') }}" placeholder="@lang('site.' . $locale . '.name')">
                    </div>

                    <div class="form-group">
                        <label for="description">@lang('site.' . $locale . '.description')</label>
                        <textarea class="form-control ckeditor" name="{{ $locale }}[description]" id="description" placeholder="@lang('site.' . $locale . '.description')">{{ old($locale . '.description') }}</textarea>
                    </div>

                    @endforeach

                    <div class="form-group">
                        <label for="category">@lang('site.category')</label>
                        <select class="form-control" name="category_id" id="category">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">@lang('site.image')</label>
                        <input class="form-control image" type="file" name="image" id="image" >
                    </div>
                    <div class="image-preview">
                        <img src="{{ asset('uploads/products/default.png') }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 100px; height: 100px">
                    </div>

                    <div class="form-group">
                        <label for="purchase_price">@lang('site.purchase_price')</label>
                        <input class="form-control" type="number" step="0.001" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" placeholder="@lang('site.purchase_price')" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="sale_price">@lang('site.sale_price')</label>
                        <input class="form-control" type="number" step="0.001"name="sale_price" id="sale_price" value="{{ old('sale_price') }}" placeholder="@lang('site.sale_price')" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="stock">@lang('site.stock')</label>
                        <input class="form-control" type="number" name="stock" id="stock" value="{{ old('stock') }}" placeholder="@lang('site.stock')" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-plus"></i> @lang('site.add')</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>

@endsection
