@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'admins',
    'second_title'  => 'Admin'
])
@section('content_header')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone " style="display:flex; justify-content:space-between">
        <h4 class="mdl-cell mdl-cell--10-col-desktop mdl-cell--10-col-tablet mdl-cell--5-col-phone">Admin Management</h4>

        @if(Auth::guard('employee')->user()->can('admin-create'))
        <a href="{{ route('admin.admin.create')}}" class="mdl-cell mdl-cell--2-col-desktop mdl-cell--2-col-tablet mdl-cell--1-col-phone">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-teal">
                <i class="material-icons">create</i>
                CREATE
            </button>
        </a>
        @endif
        
    </div>
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom/datatable.css')}}">
@endsection

@section('content_alert')
<div id="alert-section" class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone">
@if(Session::get('message'))
    <div class="alert-result alert {{ Session::get('status') ? 'color--'.Session::get('status') : ' ' }}">
        <button type="button" class="close-alert" onclick="removeAlert()">×</button>
        <i class="material-icons">{{ Session::get('icon') }}</i>
        {{ Session::get('message') }}
    </div>
@endif
</div>
@endsection

@section('content_body')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">  
    <!-- Table-->
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone ">
        <div id="loading">
            
        </div>
        <table class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-data-table mdl-js-data-table  mdl-shadow--2dp projects-table" id="usersTable">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                    <th class="mdl-data-table__cell--non-numeric">Email</th>
                    <th class="mdl-data-table__cell--non-numeric">Role</th>
                    <th class="mdl-data-table__cell--non-numeric">Status</th>
                    <th class="mdl-data-table__cell--non-numeric">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($employees as $item)
            <tr id="rows_{{$item->id}}">
                <td class="mdl-data-table__cell--non-numeric">{{$item->name}}</td>
                <td class="mdl-data-table__cell--non-numeric">{{$item->email}}</td>
                <td class="mdl-data-table__cell--non-numeric">{{$item->role}}</td>
                <td id="status_{{$item->id}}" class="mdl-data-table__cell--non-numeric">
                    <span class="label label--mini color--{{ $item->is_active == 1 ? 'green' : 'red'}}">{{ $item->is_active == 1 ? 'Active' : 'Non-Active'}}</span>
                </td>
                <td class="mdl-data-table__cell--non-numeric">
                    <button id="more_{{$item->id}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">Action</button>

                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp accounts-dropdown mdl-list pull-left"
                    for="more_{{$item->id}}">
                        @if(Auth::guard('employee')->user()->can('admin-edit'))
                        <a href="{{route('admin.admin.edit', $item->id)}}">
                            <li>
                                <button class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-teal">
                                    <i class="material-icons">edit</i>
                                    Edit
                                </button>
                            </li>
                        </a>
                        @endif

                        @if(Auth::guard('employee')->user()->can('admin-delete'))
                        <li id="block_{{ $item->id }}" {{ $item->is_active == 1 ? '' : 'style=display:none' }}>
                            <button  onclick="blockUser('{{$item->id}}')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-orange" >
                                <i class="material-icons">drafts</i>
                                Non-Active
                            </button>
                        </li>
                        <li id="restore_{{ $item->id }}" {{ $item->is_active == 0 ? '' : 'style=display:none' }}>
                            <button onclick="restoreUser('{{$item->id}}')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-orange">
                                <i class="material-icons">restore_from_trash</i>
                                Active
                            </button>
                        </li>

                        <li >
                            <button onclick="deleteUser('{{$item->id}}')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-red">
                                <i class="material-icons">delete_forever</i>
                                Delete
                            </button>
                        </li>
                        @endif
                        
                    </ul>
                </td>
            </tr>
            @empty
            <tr id="rows_null">
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('plugins/datatable/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>

@endsection

@section('inline_js')
<script>
var usersTable = $("#usersTable").DataTable({
    order: [3, 'asc'],
    pageLength: 5,
    aLengthMenu:[5,10,15,25,50],
    language: {
        searchPlaceholder: "Type Here.."
    },
    columnDefs: [
        {
            targets: 4,
            orderable: false,
            searchable: false,
        }
    ]
});

function deleteUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    $('#loading').append(`
        <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
    `);
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Destroy, and this user delete anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        console.log(result.icon);
        if(result.value){
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
                $('#rows_'+id).remove();
                // Append Alert Result
                $(`
                <div class="alert-result mdl-shadow--2dp alert color--`+result.status+`">
                    <button type="button" class="close-alert" onclick="removeAlert()">×</button>
                    <i class="material-icons">`+result.icon+`</i>
                    `+result.message+`
                </div>
                `).appendTo($("#alert-section")).slideDown("slow", "swing");
                $('#loading').empty();
            });
        }
    });
}

function blockUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Non-Active, and this user cannot login anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, block it!'
    }).then((result) => {
        if(result.value){
            $('#loading').append(`
                <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
            `);
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'block'}, function(result){
                console.log(result);
                $('#status_'+id).empty();
                $('#status_'+id).append(`
                    <span class="label label--mini color--red">Non-Active</span>
                `);
                $('#block_'+id).empty();
                $('#block_'+id).append(`
                <button onclick="restoreUser('`+id+`')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-orange">
                    <i class="material-icons">restore_from_trash</i>
                    Active
                </button>
                `);
                // Append Alert Result
                $(`
                <div class="alert-result mdl-shadow--2dp alert color--`+result.status+`">
                    <button type="button" class="close-alert" onclick="removeAlert()">×</button>
                    <i class="material-icons">`+result.icon+`</i>
                    `+result.message+`
                </div>
                `).appendTo($("#alert-section")).slideDown("slow", "swing");
                $('#loading').empty();
            });
        }
    });
}

function restoreUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });

    
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Actived, and this user can login!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Actived it!'
    }).then((result) => {
        $('#loading').append(`
            <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
        `);
        if(result.value){
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'restore'}, function(result){
                $('#status_'+id).empty();
                $('#status_'+id).append(`
                    <span class="label label--mini color--green">Active</span>
                `);
                $('#restore_'+id).empty();
                $('#restore_'+id).append(`
                <button onclick="blockUser('`+id+`')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-orange" >
                    <i class="material-icons">drafts</i>
                    Non-Active
                </button>
                `);
                // Append Alert Result
                $(`
                <div class="alert-result mdl-shadow--2dp alert color--`+result.status+`">
                    <button type="button" class="close-alert" onclick="removeAlert()">×</button>
                    <i class="material-icons">`+result.icon+`</i>
                    `+result.message+`
                </div>
                `).appendTo($("#alert-section")).slideDown("slow", "swing");
            });
        }
    });
}
</script>
<script src="{{asset('js/customs/datatable.js')}}"></script>
@endsection