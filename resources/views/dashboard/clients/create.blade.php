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
        <!-- add client -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.clients.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">@lang('site.name')</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="@lang('site.name')">
                    </div>

                    @for($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>@lang('site.phone')</label>
                        <input class="form-control" type="text" name="phone[]" value="{{ old( 'phone' . $i ) }}" placeholder="@lang('site.phone')">
                    </div>
                    @endfor

                    <div class="form-group">
                        <label for="address">@lang('site.address')</label>
                        <input class="form-control" type="text" name="address" id="address" value="{{ old('address') }}" placeholder="@lang('site.address')">
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
