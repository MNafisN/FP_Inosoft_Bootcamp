<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'transactions';


    protected $fillable = [
        'transaction_code',
        'description'
    ];
}
