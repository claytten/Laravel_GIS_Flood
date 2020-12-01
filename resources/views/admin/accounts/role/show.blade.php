@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'accounts',
  'title' => 'Role',
  'first_title' => 'Role',
  'first_link' => route('admin.role.index'),
  'second_title' => 'Show',
  'second_link' => route('admin.role.show', $role->id),
  'third_title' => $role->name
])

@section('content_alert')
<div id="alert-section">
  @if(Session::get('message'))
    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show alert-result" role="alert">
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
<div class="row">
  <div class="col-lg-12">
    <div class="card-wrapper">
      <div class="card">
        <!-- Card header -->
        <div class="card-header">
          <h3 class="mb-0">Role {{ $role->name }} || Permission Level</h3>
        </div>
        <div class="card-body">
          @foreach ($role->permissions as $item)
              {!! '<label class="badge badge-secondary">'.$item->name.'</label>' !!}
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection