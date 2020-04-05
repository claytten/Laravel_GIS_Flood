@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'roles',
    'second_title'  => 'Role'
])
@section('content_header')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone " style="display:flex; justify-content:space-between">
        <h4 class="mdl-cell mdl-cell--10-col-desktop mdl-cell--10-col-tablet mdl-cell--5-col-phone">Roles Create</h4>

        @if(Auth::guard('employee')->user()->can('roles-create'))
        <a href="{{ route('admin.role.index')}}" class="mdl-cell mdl-cell--2-col-desktop mdl-cell--2-col-tablet mdl-cell--1-col-phone">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-teal">
                <i class="material-icons">reply</i>
                Back
            </button>
        </a>
        @endif

    </div>
</div>
@endsection

@section('content_body')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">  
    <!-- Table-->
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone ">
        <div class="mdl-card mdl-shadow--2dp employer-form " action="#">
            <div class="mdl-card__title">
                <h2>Create Role</h2>
            </div>
    
            <div class="mdl-card__supporting-text">
                <form action="{{ route('admin.role.store')}}" method="POST" class="form">
                    {{ csrf_field() }}
                    
                    <div class="form__article">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input name="name" class="mdl-textfield__input" type="text" id="name" />
                                <label class="mdl-textfield__label" for="name">Role Name</label>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div id="alert-section" class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone">
                            <div class="alert-result alert color--light-blue">
                                <i class="material-icons">warning</i>
                                To assign create, edit, and delete permission, list permission is needed!
                            </div>
                        </div>
                        <div class="mdl-grid">
                            @foreach ($options as $key => $item)
                            <ul class="mdl-list pull-right" style="display:flex; flex-wrap: wrap">
                                <legend class="col-form-label">{{ ucwords(str_replace('_', ' - ', $key)) }}</legend>
                                @foreach ($item as $value)
                                <li class="mdl-list__item">
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect checkbox--colored-green" for="{{ $key.'-'.$value }}">
                                        <input type="checkbox" name="permissions[]" id="{{ $key.'-'.$value }}" class="mdl-checkbox__input checkbox_clear" value="{{ $key.'-'.$value }}" {!! $value != 'list' ? 'disabled' : "onchange=listCheck('".$key."')" !!}>
                                        <span class="mdl-checkbox__label" for="{{ $key.'-'.$value }}">{{ ucwords($value) }}</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            @endforeach
                        </div>
    
                    </div>
    
                    <div class="form__action">
                        <button type="reset" class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-red">
                            <i class="material-icons">loop</i>
                            Reset
                        </button>
                        <button type="submit" class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">
                            <i class="material-icons">create</i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('inline_js')
<script>
$('.checkbox_clear').prop('checked', false);
var key_list = [
        @foreach($options as $key => $value)
        '{{ $key }}',
        @endforeach
]

@if(old('permissions'))
var key_old = [];
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
    });
</script>
@endsection