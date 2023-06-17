<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Transaction_Code extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'transaction_code';


    protected $fillable = [
        '_id',
        'transaction_code',
        'description'
    ];
}
