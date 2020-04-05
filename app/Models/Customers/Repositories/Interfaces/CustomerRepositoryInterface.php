<?php

namespace App\Models\Customers\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Models\Customers\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Support;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function listCustomers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support;

    public function createCustomer(array $params) : Customer;

    public function updateCustomer(array $params) : bool;

    public function findCustomerById(int $id) : Customer;

    public function deleteCustomer() : bool;

    public function findOrders() : Collection;

    public function searchCustomer(string $text) : Collection;
}
