<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use App\Models\Employees\Employee;

class LoginControllerTest extends TestCase
{
    // next testing using fresh database on testing
    // use RefreshDatabase;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     app()['cache']->forget('spatie.permission.cache');

    //     $permission = Permission::create(['name' => 'admin-list','guard_name' => 'employee']);
    //     $role1 = Role::create(['name' => 'superadmin' ,'guard_name' => 'employee']);
    //     $role1->syncPermissions($permission);

    //     $this->app->make(PermissionRegistrar::class)->registerPermissions();
        
    // }

    // /** @test */
    // public function test_store_employees_data() {

    //     $admin = Employee::create([
    //         'name'=>'superadmin',
    //         'email'=>'superadmin@admin.com',
    //         'password'=> bcrypt('Superadmin_1'),
    //         'role'=> 'superadmin',
    //         'image' => null,
    //         'is_active' => true
    //     ]);
    //     $admin->assignRole('superadmin');

    //     $freshUser = Employee::find($admin->id);

    //     $this->assertTrue($freshUser->hasRole('superadmin'));
    //     $this->assertTrue($freshUser->hasPermissionTo('admin-list'));
    //     $this->assertTrue($freshUser->can('admin-list'));
    // }

    /** @test */
    public function it_store_employees_data() {
        $this->assertDatabaseHas('employees', [
            'name'  => 'superadmin',
            'email' => 'superadmin@admin.com'
        ]);
    }

    /** @test */
    public function login_displays_the_login_form() {
        $response = $this->get(route('admin.login.view'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.admin.login');
    }

    /** @test */
    public function login_displays_validation_errors() {
        $response = $this->post(route('admin.login'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }


    /** @test */
    public function login_displays_validation() {
        $response = $this->post(route('admin.login'), [
            'email'     => 'superadmin@admin.com',
            'password'  => 'Superadmin_1'
        ]);
        
        $response->assertRedirect(route('admin.dashboard'));
    }

    /** @test */
    public function logout_authenticated() {
        $response = $this->get(route('admin.logout'));

        $response->assertRedirect(route('admin.login.view'));
    }
    
}
