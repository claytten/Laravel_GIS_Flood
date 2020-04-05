<?php

use Illuminate\Database\Seeder;
use App\Models\Employees\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'=>'superadmin',
                'email'=>'superadmin@admin.com',
                'password'=> bcrypt('superadmin'),
                'role'=> 'superadmin',
                'is_active' => true
            ],
            [
                'name'=>'admin',
                'email'=>'admin@admin.com',
                'password'=> bcrypt('admin'),
                'role'=> 'admin',
                'is_active' => true
            ],
            [
                'name'=>'clerk',
                'email'=>'clerk@admin.com',
                'password'=> bcrypt('clerk'),
                'role'=> 'admin',
                'is_active' => true
            ]
        ];

        foreach($users as $item) {
            $user = Employee::where('email', $item['email'])->first();
            if(empty($user)){
                $store = Employee::create([
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'password' => $item['password'],
                    'role' => $item['role'],
                    'is_active' => $item['is_active']
                ]);

                $store->assignRole($item['role']);
            }
        }
        
    }
}
