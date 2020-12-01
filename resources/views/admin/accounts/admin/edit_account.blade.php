@extends('layouts.admin.app',[
  'headers' => 'non-active',
  'menu' => 'accounts',
])

@section('content_alert')
<div class="alert-result">
  @if(Session::get('message'))
    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show" style="z-index: 1000; margin-bottom:0" role="alert">
      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
      <span class="alert-text">{{ Session::get('message') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
</div>
@endsection

@section('headers')
<div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url({{ asset('img/default/img-1-1000x600.jpg')}}); background-size: cover; background-position: center top;">
  <!-- Mask -->
  <span class="mask bg-gradient-default opacity-8"></span>
  <!-- Header container -->
  <div class="container-fluid d-flex align-items-center">
    <div class="row">
      <div class="col-lg-7 col-md-10">
        <h1 class="display-2 text-white">Hello {{ $employee->name }}</h1>
      </div>
    </div>
  </div>
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
@endsection

@section('content_body')
<div class="row">
  <div class="col-xl-4 order-xl-2 images-content">
    <div class="card card-profile">
      <img src="{{ asset('img/default/img-1-1000x600.jpg') }}" alt="Image placeholder" class="card-img-top">
      <div class="row justify-content-center">
        <div class="col-lg-3 order-lg-2">
          <div class="card-profile-image">
            <img src="{{ 
                  !empty(auth()->guard('employee')->user()->image)
                      ? url('/storage'.'/'.auth()->guard('employee')->user()->image)
                          : asset('img/default/team-4.jpg')
              }}" alt="User Avatar" class="rounded-circle">
          </div>
        </div>
      </div>
      <br>
      <div class="text-center">
        <h5 class="h3">
          ==========
        </h5>
        <div class="h5 mt-4">
          <i class="ni business_briefcase-24 mr-2"></i>{{ $employee->name }} - {{ $employee->role }}
        </div>
        <div>
          <i class="ni education_hat mr-2"></i>{{ (!empty(config('app.name')) ? config('app.name') : 'Ikada Dashboard') }}
        </div>
      </div>
      <br>
    </div>
    <!-- Upload Photo -->
    <div class="card">
      <form action="{{ route('admin.update.account', $employee->id )}}" method="POST" enctype="multipart/form-data" id="dropzone-form">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" readonly>
        <input type="hidden" name="statStages" value="photo" readonly>
        <!-- Card header -->
        <div class="card-header">
          <!-- Title -->
          <div class="row align-items-center">
            <div class="col-8">
              <h5 class="h3 mb-0">Update Photo Profile</h5>
            </div>
            <div class="col-4 text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
        <!-- Card body -->
        <div class="card-body">
          <!-- Single -->
          <div class="mb-3">
            <div class="fallback">
              <div class="custom-file">
                <input type="file" accept=".jpg, .jpeg, .png" name="image" class="form-control imgs" onchange="previewImage(this)"id="projectCoverUploads">
                <label class="custom-file-label" for="projectCoverUploads">Choose file</label>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="card" style="align-items: center">
        <!-- Card body -->
        <div class="card-body">
          <!-- Single -->
          <div class="col-12 col-md-12 ">
            <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto remove_preview text-center" onclick="resetPreview(this)" disabled>Reset Preview</button>
            <img class="img-responsive" width="200px;" style="padding:.25rem;background:#eee;display:block;">
          </div>
        </div>
    </div>
  </div>
  <div class="col-xl-8 order-xl-1">
    <div class="card">
      {{-- Edit Profile --}}
      <form action="{{ route('admin.update.account', $employee->id )}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" readonly>
        <input type="hidden" name="statStages" value="user" readonly>
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Edit profile </h3>
            </div>
            <div class="col-4 text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="heading-small text-muted mb-4">User information</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Name</label>
                  <input type="text" id="input-username" class="form-control @error('name') is-invalid @enderror"" placeholder="Name" value="{{ $employee->name }}" name="name">
                  @error('name')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Email address</label>
                  <input type="email" id="input-email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ $employee->email }}">
                  @error('email')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <hr class="my-4" />
        </div>
      </form>

      {{-- Edit Password --}}
      <form action="{{ route('admin.update.account', $employee->id )}}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT" readonly>
        <input type="hidden" name="statStages" value="password" readonly>

        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">Edit Password </h3>
            </div>
            <div class="col-4 text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="heading-small text-muted mb-4">Password information</h6>
          <div class="pl-lg-4">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">Old Password</label>
                  <input type="password" id="input-username" class="form-control @error('oldpassword') is-invalid @enderror" placeholder="Old Password" name="oldpassword">
                  @error('oldpassword')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-username">New Password</label>
                  <input type="password" id="input-username" class="form-control @error('password') is-invalid @enderror" placeholder="New Password" name="password">
                  @error('password')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label class="form-control-label" for="input-email">Confirmation New Password</label>
                  <input type="password" id="input-email" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation New Password" name="password_confirmation">
                  @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <hr class="my-4" />
        </div>
      </form>
    </div>
  </div>
</div>
  
@endsection

@section('plugins_js')
<script src="{{ asset('vendor/select2/dist/js/select2.min.js')}}"></script>
@endsection

@section('inline_js')
<script>
  "use strict"
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
</script>
    
@endsection
