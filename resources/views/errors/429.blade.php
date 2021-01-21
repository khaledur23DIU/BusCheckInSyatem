@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'titlePage' => '429', 'title' => __('BusMama Dashboard')])
@section('content')
<div class="container" style="height: auto;">
  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter">
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1 class="title">429</h1>
            <h2>Too Many Requests :(</h2>
            <a class="btn btn-primary" href="{{ route('home') }}">{{__('Back To Home')}}</a>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection

