<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'customers';


    protected $fillable = [
        'cust_id',
        'cust_name',
        'cust_address'
    ];
}
