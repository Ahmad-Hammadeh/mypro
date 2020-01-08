@extends('layouts.dashboard.app')
@section('content')

@php
$models = ['users', 'categories', 'products', 'clients', 'orders'];
$maps = ['read', 'create', 'update', 'delete'];
@endphp

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.users')</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-users"></i> @lang('site.users')</a></li>
            <li><i class="fa fa-plus"></i> @lang('site.add')</li>
        </ol>
    </section>
    <section class="content">
        <!-- add user -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.add')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="first_name">@lang('site.first_name')</label>
                        <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="@lang('site.first_name')">
                    </div>
                    <div class="form-group">
                        <label for="last_name">@lang('site.last_name')</label>
                        <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="@lang('site.last_name')">
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('site.email')</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="@lang('site.email')">
                    </div>
                    <div class="form-group">
                        <label for="password">@lang('site.password')</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="@lang('site.password')">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">@lang('site.password_confirmation')</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="@lang('site.password_confirmation')">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input  class="form-control image" type="file" name="image">
                    </div>
                    <div class="image-preview">
                        <img src="{{ asset('uploads/users/default.png') }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 100px; height: 100px">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.permissions')</label>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                @foreach($models as $index => $model)
                                <li class="{{ $index === 0 ? 'active': '' }}"><a href="#{{ $model }}" data-toggle="tab">@lang('site.' . $model)</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($models as $index => $model)
                                <div class="tab-pane {{ $index === 0 ? 'active': '' }}" id="{{ $model }}">
                                    @foreach($maps as $map)
                                    <label><input type="checkbox" name="permissions[]" value="{{ $map . '_' . $model }}">@lang('site.' . $map)</label>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
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
