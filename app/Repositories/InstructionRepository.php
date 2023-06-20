<?php

namespace App\Repositories;

use App\Models\Instruction;

class InstructionRepository
{
    protected $instruction;

    public function __construct(Instruction $instruction)
    {
        $this->instruction = $instruction;
    }

    /** 
     * untuk mengambil list instruksi dari hasil pencarian
     */
    public function getSearched(string $query) : Object
    {
        $instructions = $this->instruction->where('instruction_id', 'LIKE', '%'.$query.'%')
                                          ->orWhere('instruction_type', 'LIKE', '%'.$query.'%')
                                          ->get();
        return $instructions;
    }


    /** 
     * untuk mengambil semua list instruksi
     */
    public function getAll() : Object
    {
        $instructions = $this->instruction->get();
        return $instructions;
    }

    /**
     * untuk mengambil data instruksi berdasarkan id
     */
    public function getById(string $instructionId) : ?Object
    {
        $instruction = $this->instruction->where('instruction_id', $instructionId)->first();
        return $instruction;
    }

    /**
     * untuk memperbarui data instruksi maupun menyimpan data instruksi baru
     */
    public function save(array $data) : Object
    {
        if (array_key_exists('instruction_id', $data)) {
            $instruction = $this->getById($data['instruction_id']);
        } else {
            $instruction = new $this->instruction;
        }

        $instruction->instruction_id = $data['instruction_id'];
        $instruction->instruction_type = $data['instruction_type'];
        $instruction->assigned_vendor = $data['assigned_vendor'];
        $instruction->vendor_address = $data['vendor_address'];
        $instruction->attention_of = $data['attention_of'];
        $instruction->quotation_number = $data['quotation_number'];
        $instruction->invoice_to = $data['invoice_to'];
        $instruction->customer_contact = $data['customer_contract'];
        $instruction->customer_po_number = $data['customer_po_number'];
        $instruction->cost_detail = $data['cost_detail'];
        $instruction->attachment = $data['attachment'];
        $instruction->notes = $data['notes'];
        $instruction->transaction_no = $data['transaction_no'];
        $instruction->invoices = $data['invoices'];
        $instruction->termination = $data['termination'];
        $instruction->instruction_status = $data['instruction_status'];

        $instruction->save();
        return $instruction->fresh();
    }
    
    /** */
    public function setComplete(string $instructionId)
    {
        $instruction = $this->getById($instructionId);
        $instruction->instruction_status = 'Completed';
        $instruction->save();
        return $instruction->fresh;
    }

    /**
     * untuk menghapus data instruksi berdasarkan id
     */
    public function delete(string $instructionId) : void
    {
        $this->instruction->where('instruction_id', $instructionId)->delete();
    }
}