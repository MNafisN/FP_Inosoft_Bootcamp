<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

use App\Models\Instruction;
use Jenssegers\Mongodb\Relations\HasOne;

class Internal extends Model
{
    // use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'internals';

    protected $fillable = [
        'instruction_id',
        'internal_attachment',
        'internal_notes',
        'activity_log'
    ];

    /**
     *  relationship with Instruction model
     * 
     * @return  Jenssegers\Mongodb\Relations\HasOne
     */
    public function Instruction() : HasOne
    {
        return $this->hasOne(Instruction::class, 'instruction_id', 'instruction_id');
    }
}
