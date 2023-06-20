<?php

namespace App\Services;

use App\Repositories\InstructionRepository;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class InstructionService
{
    protected $instructionRepository;

    public function __construct(InstructionRepository $instructionRepository)
    {
        $this->instructionRepository = $instructionRepository;
    }

    /**
     * untuk mengambil list instruction berdasarkan hasil pencarian
     */
    public function getSearched(string $query) :?Object
    {
        $instructions = $this->instructionRepository->getSearched($query);
        if ($instructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi kosong');
        }
        return $instructions;
    }

    /**
     * untuk mengambil semua list instruction di collection instructions
     */
    public function getAll() : ?Object
    {
        $instructions = $this->instructionRepository->getAll();
        if ($instructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi kosong');
        }
        return $instructions;
    }

    /**
     * untuk menambahkan data instruction baru
     */
    public function store(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'instruction_type' => 'required|string',
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'required|numeric|min:5',
            'invoice_to' => 'required',
            'customer_contact' => 'required',
            'customer_po_number' => 'required',
            'cost_detail' => 'required',
            'attachment' => 'nullable',
            'notes' => 'nullable',
            'transaction_no' => 'required',
            'invoices' => 'sometimes|required',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $newInstruction = $this->instructionRepository->save($validator->validated());
        return $newInstruction;
    }

    /**
     * untuk memodifikasi data instruction yang sudah ada
     */
    public function update(array $formData) : Object
    {
        $instruction = $this->instructionRepository->getById($formData['instruction_id']);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $validator = Validator::make($formData, [
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'required|numeric|min:5',
            'invoice_to' => 'required',
            'customer_contact' => 'required',
            'customer_po_number' => 'required',
            'cost_detail' => 'required',
            'attachment' => 'nullable',
            'notes' => 'nullable',
            'transaction_no' => 'required',
            'invoices' => 'sometimes|required',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $updatedInstruction = $this->instructionRepository->save($validator->validated());
        return $updatedInstruction;
    }

    /** */
    public function setComplete(string $instructionId)
    {
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $completedInstruction = $this->instructionRepository->setComplete($instructionId);
        return $completedInstruction;
    }

    /**
     * untuk menghapus data instruction
     */
    public function delete(array $formData) : string
    {
        $instruction = $this->instructionRepository->getById($formData['instruction_id']);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }
        $instructionId = $formData['instruction_id'];
        $this->instructionRepository->delete($instructionId);
        return $instructionId;
    }
}