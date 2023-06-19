<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use Jenssegers\Mongodb\Relations\BelongsTo;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Transaction_Code;

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
        'instruction_id',
        'instruction_type',
        'vendor_id',
        'attention_of',
        'quotation_no',
        'cust_id',
        'cust_po_number',
        'cost_detail',
        'attachment',
        'notes',
        'transaction_code',
        'invoices',
        'termination',
        'instruction_status'
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
        return $this->belongsTo(Transacrion_Code::class, 'transaction_code', 'transaction_code');
    }
}
