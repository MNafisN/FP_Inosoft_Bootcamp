<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use Jenssegers\Mongodb\Relations\BelongsTo;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\TransactionCode;

class Instruction extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'instructions';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'assigned',
        'todo_subtasks',
        'created_at',
        'updated_at'
    ];

    /**
     *  relationship with Vendor model
     * 
     * @return  Jenssegers\Mongodb\Relations\BelongsTo
     */
    public function Vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }

    /**
     *  relationship with Customer model
     * 
     * @return  Jenssegers\Mongodb\Relations\BelongsTo
     */
    public function Customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'cust_id');
    }

    /**
     *  relationship with TransactionCode model
     * 
     * @return  Jenssegers\Mongodb\Relations\BelongsTo
     */
    public function TransactionCode() : BelongsTo
    {
        return $this->belongsTo(TransacrionCode::class, 'transaction_code', 'transaction_code');
    }
}
