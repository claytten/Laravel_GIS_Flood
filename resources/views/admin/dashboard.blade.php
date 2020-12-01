@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'dashboard',
  'title' => 'Dashboard',
  'first_title' => 'Dashboard',
  'first_link' => route('admin.dashboard')
])

@section('content_alert')
<div class="alert-result">
  @if(Session::get('message'))
    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show" style="z-index: 1000; margin-bottom: 0" role="alert">
      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
      <span class="alert-text">{{ Session::get('message') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
</div>
@endsection

@section('content_body')
  <!-- Card stats -->
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card card-stats">
        <!-- Card body -->
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h5 class="card-title text-uppercase text-muted mb-0">Web Hits</h5>
              <span class="h2 font-weight-bold mb-0">0</span>
            </div>
            <div class="col-auto">
              <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                <i class="ni ni-check-bold"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection