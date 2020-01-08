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
            <li><i class="fa fa-edit"></i> @lang('site.edit')</li>
        </ol>
    </section>
    <section class="content">
        <!-- edit user -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('site.edit')</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @include('partials._errors')
                <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="first_name">@lang('site.first_name')</label>
                        <input class="form-control" type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" placeholder="@lang('site.first_name')">
                    </div>
                    <div class="form-group">
                        <label for="last_name">@lang('site.last_name')</label>
                        <input class="form-control" type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" placeholder="@lang('site.last_name')">
                    </div>
                    <div class="form-group">
                        <label for="email">@lang('site.email')</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ $user->email }}" placeholder="@lang('site.email')">
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
                        <input class="form-control image" type="file" name="image">
                    </div>
                    @if(! is_null($user->image))
                    <div class="image-preview">
                        <img src="{{ $user->image_path }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 100px; height: 100px">
                    </div>
                    @else
                    <div class="image-preview">
                        <img src="{{ asset('uploads/users/default.png') }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 100px; height: 100px">
                    </div>
                    @endif
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
                                    <label><input type="checkbox" name="permissions[]" value="{{ $map . '_' . $model }}" {{ $user->hasPermission($map . '_' . $model) ? 'checked' : '' }}>@lang('site.' . $map)</label>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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
