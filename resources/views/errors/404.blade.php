@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'titlePage' => '404', 'title' => __('BusMama Dashboard')])
@section('content')
<div class="container" style="height: auto;">
  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter">
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1 class="title">404</h1>
            <h2>Page not found :(</h2>
            <h4>Ooooups! Looks like you got lost.</h4>
            <a class="btn btn-primary" href="{{ route('home') }}">{{__('Back To Home')}}</a>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

