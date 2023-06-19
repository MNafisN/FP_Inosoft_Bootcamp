<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'vendors';


    protected $fillable = [
        'vendor_id',
        'vendor_name',
        'vendor_description',
        'vendor_phone_number',
        'vendor_address',
        'vendor_invoice_provider'
    ];
}
