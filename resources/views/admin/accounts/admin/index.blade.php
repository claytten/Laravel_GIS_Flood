@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'accounts',
  'title' => 'Admin',
  'first_title' => 'Admin',
  'first_link' => route('admin.admin.index')
])

@section('content_alert')
<div id="alert-result">
  @if(Session::get('message'))
    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show alert-result" style="margin-bottom: 0" role="alert">
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
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}">
@endsection

@section('header-right')
@if(Auth::guard('employee')->user()->can('admin-create'))
  <div class="col-lg-6 col-5 text-right">
    <a href="{{ route('admin.admin.create') }}" class="btn btn-sm btn-neutral">New</a>
  </div>
@endif
@endsection

@section('content_body')
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Admin Management</h3>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="usersTable">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($employees as $item)
                    <tr id="rows_{{ $item->id }}">
                        <td>{{ ucwords($item->name) }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->is_active ?  'Active' : 'Inactive' }}</td>
                        <td>
                          <div class="dropdown">
                            <a class="btn btn-md btn-icon-only text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ni ni-settings-gear-65"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                              @if(Auth::guard('employee')->user()->can('admin-edit'))
                                  <a href="{{ route('admin.admin.edit', $item->id) }}" class="dropdown-item text-warning">Edit</a>
                              @endif
                              @if(Auth::guard('employee')->user()->can('admin-delete'))
                                  <button onclick="blockUser('{{ $item->id }}')" class="dropdown-item text-danger" id="block_{{ $item->id }}" {{ $item->is_active ? '' : 'style=display:none' }}>Block</button>
                                  <button onclick="restoreUser('{{ $item->id }}')" class="dropdown-item text-success" id="restore_{{ $item->id }}" {{ $item->is_active ? 'style=display:none' : '' }}>Restore</button>
                                  <button onclick="deleteUser('{{ $item->id }}')" class="dropdown-item text-danger" id="block_{{ $item->id }}">Delete</button>
                              @endif
                            </div>
                          </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
  "use strict"
  const DatatableButtons = (function() {

    // Variables

    var $dtButtons = $('#usersTable');


    // Methods

    function init($this) {

      // For more options check out the Datatables Docs:
      // https://datatables.net/extensions/buttons/

      var buttons = ["copy", "print"];

      // Basic options. For more options check out the Datatables Docs:
      // https://datatables.net/manual/options

      var options = {
        order: [3, 'asc'],
        lengthChange: !1,
        dom: 'Bfrtip',
        buttons: buttons,
        // select: {
        // 	style: "multi"
        // },
        language: {
          paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
          }
        },
        columnDefs: [
        {
            targets: 4,
            orderable: false,
            searchable: false,
        }
    ],
      };

      // Init the datatable

      var table = $this.on( 'init.dt', function () {
        $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
        }).DataTable(options);
    }


    // Events

    if ($dtButtons.length) {
      init($dtButtons);
    }

  })();
  function deleteUser(id){
      $(".alert-result").slideUp(function(){
          $(this).remove();
      });
      Swal.fire({
          title: 'Are you sure?',
          text: "This user status will be set to Destroy, and this user delete anymore!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if(result.value){
              $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
                  // Append Alert Result
                  $(`
                  <div class="alert alert-`+ result.status +` alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                    <span class="alert-text">`+ result.message +`</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  `).appendTo($("#alert-result")).slideDown("slow", "swing");
                  setTimeout(location.reload.bind(location), 1000);
              }).fail(function(jqXHR, textStatus, errorThrown){
  
                  $.each(jqXHR.responseJSON.errors, function(key, result) {
                    $(`
                    <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                      <span class="alert-text">`+ jqXHR.responseText +`</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    `).appendTo($("#alert-result")).slideDown("slow", "swing");
                    setTimeout(location.reload.bind(location), 1000);
                  });
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
              $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'block'}, function(result){
                  // Append Alert Result
                  $(`
                  <div class="alert alert-`+ result.status +` alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                    <span class="alert-text">`+ result.message +`</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  `).appendTo($("#alert-result")).slideDown("slow", "swing");
                  setTimeout(location.reload.bind(location), 1000);
              }).fail(function(jqXHR, textStatus, errorThrown){
  
                  $.each(jqXHR.responseJSON.errors, function(key, result) {
                    $(`
                    <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                      <span class="alert-text">`+ jqXHR.responseText +`</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    `).appendTo($("#alert-result")).slideDown("slow", "swing");
                    setTimeout(location.reload.bind(location), 1000);
                  });
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
          $('#loading').show();
          if(result.value){
              $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'restore'}, function(result){
                  // Append Alert Result
                  $(`
                  <div class="alert alert-`+ result.status +` alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                    <span class="alert-text">`+ result.message +`</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  `).appendTo($("#alert-result")).slideDown("slow", "swing");
                  setTimeout(location.reload.bind(location), 1000);
              }).fail(function(jqXHR, textStatus, errorThrown){
  
                  $.each(jqXHR.responseJSON.errors, function(key, result) {
                    $(`
                    <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                      <span class="alert-text">`+ jqXHR.responseText +`</span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    `).appendTo($("#alert-result")).slideDown("slow", "swing");
                    setTimeout(location.reload.bind(location), 1000);
                  });
              });
          }
      });
  }
  </script>
    
@endsection