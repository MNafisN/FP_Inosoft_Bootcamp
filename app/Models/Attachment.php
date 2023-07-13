<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use App\Models\Instruction;
use Jenssegers\Mongodb\Relations\HasOne;

class Attachment extends Model
{
    // use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'attachments';

    protected $fillable = [
        // 'instruction_id',
        'file_name',
        'posted_by',
        'created_at'
    ];

    // /**
    //  *  relationship with Instruction model
    //  * 
    //  * @return  Jenssegers\Mongodb\Relations\HasOne
    //  */
    // public function Instruction() : HasOne
    // {
    //     return $this->hasOne(Instruction::class, 'instruction_id', 'instruction_id');
    // }
}
