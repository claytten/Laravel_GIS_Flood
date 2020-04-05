@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'admins',
    'second_title'  => 'Admin'
])

@section('content_alert')
@if(Session::get('message'))
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone mdl-shadow--2dp alert {{ Session::get('status') ? 'color--'.Session::get('status') : ' ' }}">
        <button type="button" class="close-alert" onclick="removeAlert()">×</button>
        <i class="material-icons">{{ Session::get('icon') }}</i>
        {{ Session::get('message') }}
    </div>
@endif
@endsection

@section('content_body')
<main class="mdl-layout__content mdl-color--grey-100">
    <div class="mdl-card mdl-shadow--2dp employer-form " action="#">
        <div class="mdl-card__title">
            <h2>Edit {{ucwords($employee->name)}} Account</h2>
        </div>

        <div class="mdl-card__supporting-text">
            <form action="{{ route('admin.admin.update',$employee->id)}}" method="POST" class="form">
                {{ csrf_field() }}
                @method('PUT')
                <div class="form__article">
                    <h3>Personal data</h3>

                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input name="name" class="mdl-textfield__input" type="text" id="name" value="{{$employee->name}}"/>
                            <label class="mdl-textfield__label" for="name">First name</label>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input name="email" class="mdl-textfield__input" type="email" id="email" value="{{$employee->email}}"/>
                            <label class="mdl-textfield__label" for="email">Email</label>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input name="password" class="mdl-textfield__input" type="password" id="password"/>
                            <label class="mdl-textfield__label" for="password">New Password</label>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input name="password_confirmation" class="mdl-textfield__input" type="password" id="password_confirmation"/>
                            <label class="mdl-textfield__label" for="password_confirmation">New Password Confirmation</label>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="form__action">
                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="isInfoReliable">
                        <input name="agree" type="checkbox" id="isInfoReliable" class="mdl-checkbox__input" required value="check"/>
                        <span class="mdl-checkbox__label">Agree with Term and Conditions</span>
                    </label>
                    <button id="submit_button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" onclick="submit_form()">
                        Submit
                    </button>
                </div>
            </form>
        </div>
        <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
    </div>
</main>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('.loading').hide();
    });

    function submit_form() {
        $('.loading').show();
    }
</script>
@endsection