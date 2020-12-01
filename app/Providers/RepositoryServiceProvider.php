<?php

namespace App\Providers;

use App\Models\Employees\Repositories\EmployeeRepository;
use App\Models\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Models\Categories\Repositories\CategoryRepository;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Categories\Subcategories\Repositories\SubcategoryRepository;
use App\Models\Categories\Subcategories\Repositories\Interfaces\SubcategoryRepositoryInterface;
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
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            SubcategoryRepositoryInterface::class,
            SubcategoryRepository::class
        );

        $this->app->bind(
            FieldRepositoryInterface::class,
            FieldRepository::class
        );
    }
}
