<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;
use Jenssegers\Mongodb\Relations\BelongsTo;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Transaction;

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
        'instruction_status',
        'issued_by',
        'date_of_issue'
    ];

    public function nextLId()
    {
        $idNow = "LI-" . date("Y") . "-";
        // ref is the counter - change it to whatever you want to increment
        $this->instruction_id = $idNow . str_pad(self::getID('LI'), 4, '0', STR_PAD_LEFT);
    }

    public function nextSId()
    {
        $idNow = "SI-" . date("Y") . "-";

        $this->instruction_id = $idNow . str_pad(self::getID('SI'), 4, '0', STR_PAD_LEFT);
    }

    public static function bootUseAutoIncrementID()
    {
        static::creating(function ($model) {
            $model->sequencial_id = self::getID($model->getTable());
        });
    }

    public function getCasts()
    {
        return $this->casts;
    }
    
    private static function getID(string $type)
    {
        if ($type == 'LI') {
            $seq = DB::connection('mongodb')->getCollection('instructions_count')->findOneAndUpdate(
                ['ref' => 'ref'],
                ['$inc' => ['li_seq' => 1]],
                ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
            );
            return $seq->li_seq;
        } else if ($type == 'SI') {
            $seq = DB::connection('mongodb')->getCollection('instructions_count')->findOneAndUpdate(
                ['ref' => 'ref'],
                ['$inc' => ['si_seq' => 1]],
                ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
            );
            return $seq->si_seq;
        }
    }

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
        return $this->belongsTo(Transaction::class, 'transaction_code', 'transaction_code');
    }
}
