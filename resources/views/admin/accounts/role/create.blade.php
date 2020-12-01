@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'accounts',
  'title' => 'Role',
  'first_title' => 'Role',
  'first_link' => route('admin.role.index'),
  'second_title' => 'Create'
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
<form action="{{ route('admin.role.store') }}" method="POST">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-lg-6">
      <div class="card-wrapper">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Permission Level</h3>
          </div>
          <div class="card-body">
            @foreach ($options as $key => $item)
            <!-- {{ ucwords(str_replace('_', ' - ', $key)) }} -->
            <fieldset class="form-group">
                <legend class="col-form-label">{{ ucwords(str_replace('_', ' - ', $key)) }}</legend>
                <div class="row">
                    @foreach ($item as $value)
                    <div class="col-12 col-md-3">
                        <div class="custom-control custom-checkbox mb-1">
                            <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $key.'-'.$value }}" id="{{ $key.'-'.$value }}" {!! $value != 'list' ? 'disabled' : "onchange=listCheck('".$key."')" !!}>
                            <label for="{{ $key.'-'.$value }}" class="custom-control-label">{{ ucwords($value) }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card-wrapper">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Roles Information</h3>
              </div>
              <div class="col-lg-2 text-right">
                <button type="button" class="btn btn-danger" id="btn-reset">Reset</button>
              </div>
              <div class="col-lg-2 text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <!-- Input groups with icon -->
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control @error('name') is-invalid @enderror" placeholder="Role Name" type="text" name="name" value="{{ old('name') }}" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                </div>
                <div class="alert alert-result alert-warning fade show mb-0" role="alert">
                    <span><i class="material-icons">warning</i> To assign create, edit, and delete permission, list permission is needed!</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('inline_js')
<script>
  "use strict"
  let key_list = [
      @foreach($options as $key => $value)
      '{{ $key }}',
      @endforeach
  ]

  @if(old('permissions'))
  let key_old = [];
  @foreach(old('permissions') as $permission)
  key_old.push("{{ $permission }}");
  @endforeach
  @endif

  $(document).ready(function(){
      key_list.forEach(function(obj){
          @if(old('permissions'))
              if(key_old.includes(obj+'-list')){
                  $("#"+obj+'-list').prop('checked', true);
              }
          @endif

          listCheck(obj);
      });
  });

  function listCheck(permission){
      console.log("Check Permission is running...");

      if($("#"+permission+"-list").prop('checked') === true){
          $("#"+permission+'-create').attr('disabled', false);
          $("#"+permission+'-edit').attr('disabled', false);
          $("#"+permission+'-delete').attr('disabled', false);

          @if(old('permissions'))
          if(key_old.includes(permission+'-create')){
              $("#"+permission+'-create').prop('checked', true);
          } else {
              $("#"+permission+'-create').prop('checked', false);
          }

          if(key_old.includes(permission+'-edit')){
              $("#"+permission+'-edit').prop('checked', true);
          } else {
              $("#"+permission+'-edit').prop('checked', false);
          }

          if(key_old.includes(permission+'-delete')){
              $("#"+permission+'-delete').prop('checked', true);
          } else {
              $("#"+permission+'-delete').prop('checked', false);
          }
          @endif
      } else {
          $("#"+permission+'-create').prop('checked', false).attr('disabled', true);
          $("#"+permission+'-edit').prop('checked', false).attr('disabled', true);
          $("#"+permission+'-delete').prop('checked', false).attr('disabled', true);
      }
  }

  $("#btn-reset").click(function(e){
      e.preventDefault();
      $("#name").val('');

      key_list.forEach(function(obj){
          $("#"+obj+"-list").prop('checked', false);
          listCheck(obj);
      });
      // checkboxCheck();
  });
</script>
    
@endsection