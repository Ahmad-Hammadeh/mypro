@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.categories')</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.categories.index')}}"><i class="fa fa-list"></i> @lang('site.categories')</a></li>
            <li><i class="fa fa-plus"></i> @lang('site.add')</li>
        </ol>
    </section>
    <section class="content">
        <!-- add category -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.categories.store') }}" method="post">
                    @csrf

                    @foreach(config('translatable.locales') as $locale)

                    <div class="form-group">
                        <label for="name">@lang('site.' . $locale . '.name')</label>
                        <input class="form-control" type="text" name="{{ $locale }}[name]" id="name" value="{{ old($locale . '.name') }}" placeholder="@lang('site.' . $locale . '.name')">
                    </div>

                    @endforeach
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
