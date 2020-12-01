@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'accounts',
  'title' => 'Admin',
  'first_title' => 'Admin',
  'first_link' => route('admin.admin.index'),
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

@section('plugins_css')
<link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endsection


@section('content_body')
<form action="{{ route('admin.admin.store') }}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="row">
    <div class="col-lg-6">
      <div class="card-wrapper">
        <!-- Input groups -->
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Employee Information</h3>
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
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input class="form-control @error('name') is-invalid @enderror" placeholder="Your name" type="text" name="name" value="{{ old('name') }}" id="name">
                      @error('name')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group input-group-merge">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input class="form-control @error('email') is-invalid @enderror" placeholder="Email address" type="email" name="email" value="{{ old('email')}}" id="email">
                      @error('email')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group input-group-merge">
                      <input class="form-control @error('password') is-invalid @enderror" placeholder="Password" type="password" name="password" id="password">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                      </div>
                      @error('password')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="input-group input-group-merge">
                      <input class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Re-type Password" type="password" name="password_confirmation" id="password_confirmation">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-eye"></i></span>
                      </div>
                      @error('password_confirmation')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="row images-content">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="input-group input-group-merge">
                      <div class="custom-file">
                        <input type="file" accept=".jpg, .jpeg, .png" name="image" class="form-control imgs" onchange="previewImage(this)"id="projectCoverUploads">
                        <label class="custom-file-label" for="projectCoverUploads">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group" style="align-items: center">
                    <div class="input-group">
                      <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto remove_preview text-center" onclick="resetPreview(this)" disabled>Reset Preview</button>
                    </div>
                    <div class="input-group" style="justify-content: center">
                      <img class="img-responsive" width="200px;" style="padding:.25rem;background:#eee;display:block;">
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card-wrapper">
        <!-- Roles -->
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Roles</h3>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" data-toggle="select">
                <option value=""></option>
                @foreach($roles as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
            @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>
        <!-- Toggle buttons -->
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Publish</h3>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <label class="custom-toggle custom-toggle-default">
              <input type="checkbox" name="is_active">
              <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ asset('vendor/select2/dist/js/select2.min.js')}}"></script>
@endsection

@section('inline_js')
<script>
  "use strict"
  $(document).ready(function() {
      $('#role').select2({
          'placeholder': 'Select Role',
      });
  });

  // Add More Image
  function previewImage(input){
        console.log("Preview Image");
        let preview_image = $(input).closest('.images-content').find('.img-responsive');
        let preview_button = $(input).closest('.images-content').find('.remove_preview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // console.log(e.target.result);
                $(preview_image).attr('src', e.target.result);
                
            }
            $('.custom-file-label').html(input.files[0].name);
            reader.readAsDataURL(input.files[0]);
            $(preview_button).prop('disabled', false);
        }
    }

    function resetPreview(input){

        let preview_image = $(input).closest('.images-content').find('.img-responsive');
        let preview_button = $(input).closest('.images-content').find('.remove_preview');
        let preview_form = $(input).closest('.images-content').find('.imgs');

        $('.custom-file-label').html('Choose File');
        $(preview_image).attr('src', '');
        $(preview_button).prop('disabled', true);
        $(preview_form).val('');
    }
  $("#btn-reset").click(function(e){
    e.preventDefault();
    $("#name").val('');
    $('#email').val('');
    $('#password').val('');
    $('#password_confirmation').val('');
  });
</script>
    
@endsection