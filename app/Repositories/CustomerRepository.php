<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /** 
     * untuk mengambil semua list customer
     */
    public function getAll() : Object
    {
        $customers = $this->customer->select('cust_name')->get();
        return $customers;
    }

    /**
     * untuk mengambil data customer berdasarkan id
     */
    public function getById(string $customerId) : ?Object
    {
        $customer = $this->customer->where('cust_id', $customerId)->first();
        return $customer;
    }

}