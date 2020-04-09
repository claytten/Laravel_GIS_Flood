<?php

namespace App\Providers;

use App\Models\Customers\Repositories\CustomerRepository;
use App\Models\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Models\Employees\Repositories\EmployeeRepository;
use App\Models\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Models\Maps\Fields\Repositories\FieldRepository;
use App\Models\Maps\Fields\Repositories\Interfaces\FieldRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->bind(
            FieldRepositoryInterface::class,
            FieldRepository::class
        );
    }
}
