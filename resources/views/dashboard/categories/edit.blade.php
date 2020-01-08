@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.categories')</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.categories.index')}}"><i class="fa fa-list"></i> @lang('site.categories')</a></li>
            <li><i class="fa fa-edit"></i> @lang('site.edit')</li>
        </ol>
    </section>
    <section class="content">
        <!-- edit category -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.edit')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('put')

                    @foreach(config('translatable.locales') as $locale)

                    <div class="form-group">
                        <label for="name">@lang('site.' . $locale . '.name')</label>
                        <input class="form-control" type="text" name="{{ $locale }}[name]" id="name" value="{{ $category->translate($locale)->name }}" placeholder="@lang('site.' . $locale . '.name')">
                    </div>

                    @endforeach
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="@lang('site.edit')">
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
</div>

@endsection
