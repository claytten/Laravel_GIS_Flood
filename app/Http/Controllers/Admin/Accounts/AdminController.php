<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Models\Employees\Requests\CreateEmployeeRequest;
use App\Models\Employees\Requests\UpdateEmployeeRequest;
use App\Models\Employees\Repositories\EmployeeRepository;
use App\Models\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;

use App\Http\Middleware\CustomRoleSpatie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepo;

    /**
     * Admin Controller Constructor
     *
     * @param EmployeeRepositoryInterface $employeeRepository
     * @return void
     */
    public function __construct(
        EmployeeRepositoryInterface $employeeRepository
    )
    {
        // Spatie ACL
        $this->middleware('permission:admin-list');
        $this->middleware('permission:admin-create', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);

        $this->employeeRepo = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employeeRepo->listEmployees()->sortBy('name')->take(5);
        return view('admin.accounts.admin.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = CustomRoleSpatie::pluck('name', 'name')->all();
        return view('admin.accounts.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $this->employeeRepo->createEmployee($request->all());

        return redirect()->route('admin.admin.index')->with([
            'icon'      => 'check',
            'status'    => 'green',
            'message'   => 'Create Admin successful!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = $this->employeeRepo->findEmployeeById($id);
        return view('admin.accounts.admin.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        if($request->agree != "check") {
            return redirect()->route('admin.admin.edit', $id)->with([
                'icon'      => 'check',
                'status'    => 'green',
                'message'   => 'Update successful!'
            ]);
        }
        
        $employee = $this->employeeRepo->findEmployeeById($id);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->updateEmployee($request->all());
        

        return redirect()->route('admin.admin.edit', $id)->with([
            'icon'      => 'check',
            'status'    => 'green',
            'message'   => 'Update successful!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $users = $this->employeeRepo->findEmployeeById($id);
        $user = new EmployeeRepository($users);
        $message = '';
        if($request->user_action == 'block'){
            $users->is_active = false;
            $users->save();
            $message = 'User successfully blocked';
        } else if( $request->user_action == 'restore') {
            $users->is_active = true;
            $users->save();
            $message = 'User successfully restored';
        } else {
            $user = new EmployeeRepository($users);
            $user->deleteEmployee();
        }

        return response()->json([
            'icon'   => 'check',
            'status' => 'green',
            'message' => $message,
            'user_status' => $users->is_active
        ]);
    }
}
