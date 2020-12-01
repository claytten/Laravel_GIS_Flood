@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'accounts',
  'title' => 'Role',
  'first_title' => 'Role',
  'first_link' => route('admin.role.index')
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
@if(Auth::guard('employee')->user()->can('roles-create'))
  <div class="col-lg-6 col-5 text-right">
    <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-neutral">New</a>
  </div>
@endif
@endsection

@section('content_body')
    <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Role Management</h3>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="rolesTable">
              <thead class="thead-light">
                <tr>
                  <th>Name</th>
                  <th>User Assigned</th>
                  <th>Permission Count</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>User Assigned</th>
                  <th>Permission Count</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($roles as $item)
                  <tr id="rows_{{ $item->id }}">
                    <td>{{ucwords($item->name)}}</td>
                    <td>{{ $item->employees_count }}</td>
                    <td>{{$item->permissions_count}}</td>
                    <td>
                      <div class="dropdown">
                        <a class="btn btn-md btn-icon-only text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="ni ni-settings-gear-65"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          @if(Auth::guard('employee')->user()->can('roles-edit'))
                              <a href="{{ route('admin.role.edit', $item->id) }}" class="dropdown-item text-warning">Edit</a>
                              <a href="{{ route('admin.role.show', $item->id) }}" class="dropdown-item text-primary">Show</a>
                          @endif
                          @if(Auth::guard('employee')->user()->can('roles-delete'))
                              <button onclick="deleteRole('{{ $item->id }}')" class="dropdown-item text-danger" id="block_{{ $item->id }}">Delete</button>
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
  var DatatableButtons = (function() {

    // Variables

    var $dtButtons = $('#rolesTable');


    // Methods

    function init($this) {

      // For more options check out the Datatables Docs:
      // https://datatables.net/extensions/buttons/

      var buttons = ["copy", "print"];

      // Basic options. For more options check out the Datatables Docs:
      // https://datatables.net/manual/options

      var options = {
        order: [2, 'asc'],
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
            targets: 3,
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
  function deleteRole(id){
      $(".alert-result").slideUp(function(){
          $(this).remove();
      });
      Swal.fire({
          title: 'Are you sure?',
          text: "This user status will be set to Destroy, and this role delete anymore!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if(result.value){
              $.post("{{ route('admin.role.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
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