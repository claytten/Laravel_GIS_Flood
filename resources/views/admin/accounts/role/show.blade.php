@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'roles',
    'second_title'  => 'Role Detail'
])
@section('content_header')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone " style="display:flex; justify-content:space-between">
        <h4 class="mdl-cell mdl-cell--10-col-desktop mdl-cell--10-col-tablet mdl-cell--5-col-phone">Roles Detail</h4>

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
<main class="mdl-layout__content ui-form-components">

    <div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">

        <div class="mdl-cell mdl-cell--5-col-desktop mdl-cell--5-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h5 class="mdl-card__title-text text-color--white">Role Name  : {{ $role->name}}</h5>
                </div>
                <div class="mdl-card__supporting-text">
                    <form class="form form--basic">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone form__article">
                                <h3 style="margin-bottom:0">List Permissions</h3>
                                <ul class="mdl-list pull-left" style="display:flex; flex-wrap:wrap">
                                    @foreach ($role->permissions as $item)
                                    <li class="mdl-list__item" style="padding: 5px">
                                        <button type="button" class="mdl-chip color--teal mdl-color-text--white">
                                            <span class="mdl-chip__text">{{$item->name}}</span>
                                        </button>
                                    </li>
                                    @endforeach
                                </ul>
                                {{-- <div class="mdl-textfield mdl-js-textfield full-size">
                                    <input class="mdl-textfield__input" type="text" id="e-mail">
                                    <label class="mdl-textfield__label" for="e-mail">Email</label>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--7-col-tablet mdl-cell--5-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h5 class="mdl-card__title-text text-color--white">Employee with {{$role->name}} role</h5>
                </div>
                <div class="form form-basic">
                    <div class="mdl-grid">
                        <table class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone mdl-data-table mdl-js-data-table bordered-table">
                            <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">Name</th>
                                <th class="mdl-data-table__cell--non-numeric">Role</th>
                                <th class="mdl-data-table__cell--non-numeric">Created Date</th>
                                <th class="mdl-data-table__cell--non-numeric">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($role->employees as $item)
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">{{$item->name}}</td>
                                    <td class="mdl-data-table__cell--non-numeric">{{$item->role}}</td>
                                    <td class="mdl-data-table__cell--non-numeric">{{$item->created_at}}</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        @if($item->is_active == 1)
                                            <span class="label label--mini background-color--primary">
                                                Active
                                            </span> 
                                        @else
                                            <span class="label label--mini background-color--primary">
                                                Non-Active
                                            </span> 
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('inline_js')
<script>
</script>
@endsection