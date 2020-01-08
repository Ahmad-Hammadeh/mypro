@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.users')</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.welcome')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li class="active"><i class="fa fa-users"></i> @lang('site.users')</li>
        </ol>
    </section>
    <section class="content">
        <!-- all users -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" style="margin-bottom: 15px;">@lang('site.users') <small>{{ $users->total() }}</small></h3>
                <form action="{{ route('dashboard.users.index') }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="@lang('site.search')">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>

                            @if(auth()->user()->hasPermission('create_users'))
                            <a class="btn btn-success" href="{{route('dashboard.users.create')}}"><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @else
                            <a class="btn btn-success" href="#" disabled><i class="fa fa-plus"></i> @lang('site.add')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                @if($users->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.first_name')</th>
                            <th>@lang('site.last_name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.action')</th>
                            <th>@lang('site.image')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $users as $index => $user )
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>

                            @if(! is_null($user->image))
                            <td>
                                <img src="{{ $user->image_path }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 64px; height: 64px">
                            </td>
                            @else
                            <td>
                                <img src="{{ asset('uploads/users/default.png') }}" alt="@lang('site.image')" class="img-thumbnail" style="width: 64px; height: 64px">
                            </td>
                            @endif

                            <td>

                                @if(auth()->user()->hasPermission('update_users') )
                                <a class="btn btn-info btn-sm" href="{{route('dashboard.users.edit', $user->id)}}"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                <a class="btn btn-info btn-sm" href="#" disabled><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_users'))
                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post" style="display:inline-block;">
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
                {{ $users->appends(['search' => request('search')])->links() }}
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
