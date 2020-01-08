@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>Blank Page
            <small>It starts here</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-users"></i> @lang('site.users')</a></li>
        </ol>
    </section>
    <section class="content">
        <h1>This is dashboard</h1>
    </section>
</div>

@endsection
