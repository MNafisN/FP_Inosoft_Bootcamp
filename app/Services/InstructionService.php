<?php

namespace App\Services;

use App\Repositories\InstructionRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\VendorRepository;
use App\Repositories\InternalRepository;

use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InstructionService
{
    protected $instructionRepository;
    protected $customerRepository;
    protected $vendorRepository;
    protected $transactionRepository;

    public function __construct(
            InstructionRepository $instructionRepository,
            CustomerRepository $customerRepository,
            TransactionRepository $transactionRepository,
            VendorRepository $vendorRepository
        )
    {
        $this->instructionRepository = $instructionRepository;
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * untuk mengambil list instruction berdasarkan hasil pencarian
     */
    public function getSearched(string $query) : ?Object
    {
        $queryDecoder = urldecode($query);
        $instructions = $this->instructionRepository->getSearched($queryDecoder);
        if ($instructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
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
     * untuk mengambil semua list instruction di collection instructions yang berstatus in progress
     */
    public function getInProgress() : ?Object
    {
        $instructions = $this->instructionRepository->getStatus('In Progress');
        if ($instructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi berstatus In Progress kosong');
        }
        return $instructions;
    }

    /**
     * untuk mengambil semua list instruction di collection instructions yang berstatus draft
     */
    public function getDraft() : ?Object
    {
        $instructions = $this->instructionRepository->getStatus('Draft');
        if ($instructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi berstatus Draft kosong');
        }
        return $instructions;
    }

    /**
     * untuk mengambil semua list instruction di collection instructions yang berstatus draft dan in progress
     */
    public function getOpen() : ?Object
    {
        $draftInstructions = $this->instructionRepository->getStatus('Draft');
        $inProgressInstructions = $this->instructionRepository->getStatus('In Progress');
        if ($draftInstructions->isEmpty() && $inProgressInstructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi berstatus Draft maupun In Progress kosong');
        }
        $instructions = $draftInstructions->merge($inProgressInstructions);
        return $instructions;
    }

    /**
     * untuk mengambil semua list instruction di collection instructions yang berstatus cancelled dan completed
     */
    public function getCompleted() : ?Object
    {
        $cancelledInstructions = $this->instructionRepository->getStatus('Cancelled');
        $completedInstructions = $this->instructionRepository->getStatus('Completed');
        if ($cancelledInstructions->isEmpty() && $completedInstructions->isEmpty()) {
            throw new InvalidArgumentException('Data instruksi berstatus Completed maupun Cancelled kosong');
        }
        $instructions = $cancelledInstructions->merge($completedInstructions);
        return $instructions;
    }

    /**
     * untuk mengambil data instruksi berdasarkan instruction id
     */
    public function getById(string $instructionId) : Object
    {
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }
        return $instruction;
    }

    /**
     * untuk menyediakan data vendor, vendor address, invoice to, dan customer pada form instruksi
     */
    public function getInstructionFormData() : array
    {
        $customers = $this->customerRepository->getAll();
        $transactions = $this->transactionRepository->getAll();
        $vendors = $this->vendorRepository->getAll();

        if ($customers->isEmpty() || $transactions->isEmpty() || $vendors->isEmpty()) {
            throw new InvalidArgumentException('Ada form data yang kosong karena tabel customers/transactions/vendors kosong');
        }

        $data['customers'] = $customers->toArray();
        $data['transactions'] = $transactions->toArray();
        $data['vendors'] = $vendors->toArray();
        return $data;
    }

    /**
     * untuk menambahkan data instruction baru
     */
    public function store(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string|unique:App\Models\Instruction,instruction_id',
            'instruction_type' => 'required|string',
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'nullable|numeric|min:5',
            'invoice_to' => 'sometimes|required',
            'customer_contact' => 'sometimes|required',
            'cust_po_number' => 'nullable|required',
            'cost_detail' => 'required',
            'attachment.*' => 'sometimes|nullable|mimes:jpg,jpeg,png,pdf|max:20000',
            'notes' => 'nullable',
            'transaction_code' => 'sometimes|required',
            'invoices' => 'sometimes|nullable',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
        ],
        [
            // 'attachment.*.required' => 'Please upload a file',
            'attachment.*.mimes' => 'Only jpeg, png and pdf images are allowed',
            'attachment.*.max' => 'Sorry! Maximum allowed size for a file is 20MB',
        ]);

        if ($formData['cost_detail']) {
            for ($i=0; $i<count($formData['cost_detail']); $i++) {
                $validatorCostDetail = Validator::make($formData['cost_detail'][$i], [
                    'cost_description' => 'required',
                    'quantity' => 'required|numeric|min:0|not_in:0',
                    'unit_of_measurement' => 'required|in:MEN,PCS,HRS,MT',
                    'unit_price' => 'required|numeric|min:0',
                    'GST_percentage' => 'numeric|min:0',
                    'currency' => 'required|in:USD,AUD',
                    'vat_amount' => 'required|numeric',
                    'sub_total' => 'required|numeric',
                    'total' => 'required|numeric',
                    'charge_to' => 'required|string'
                ]);
                if ($validatorCostDetail->fails()) {
                    $costDetailErrors['cost_detail_'.$i] = $validatorCostDetail->errors()->toArray();
                }
            }
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
        }

        if (isset($errors)) {
            $errMessageBag = $errors->toArray(); 
            if (isset($costDetailErrors)) {
                $errMessageBag['cost_detail'] = $costDetailErrors;
            }
            throw ValidationException::withMessages($errMessageBag);
        }

        $newInstruction = $this->instructionRepository->save($formData);

        $storeVendorData = $this->vendorRepository->save(array_intersect_key($validator->validated(), array_flip(['assigned_vendor', 'vendor_address', 'invoice_to'])));
        if (!$storeVendorData) {
            throw ValidationException::withMessages(['ERROR VENDOR NOT AVAILABLE']);
        }

        return $newInstruction;
    }

    /**
     * untuk memperbarui attachment instruksi
     */
    public function updateAttachment(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'attachment.*' => 'sometimes|nullable|mimes:jpg,jpeg,png,pdf|max:20000',
        ],
        [
            // 'attachment.*.required' => 'Please upload a file',
            'attachment.*.mimes' => 'Only jpeg, png and pdf images are allowed',
            'attachment.*.max' => 'Sorry! Maximum allowed size for a file is 20MB',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $instruction = $this->instructionRepository->getById($formData['instruction_id']);
        if (!$instruction) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan']);
        }

        $updatedInstruction = $this->instructionRepository->saveAttachment($formData);
        return $updatedInstruction;
    }

    /**
     * untuk memodifikasi data instruction yang sudah ada
     */
    public function update(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'nullable|numeric|min:5',
            'invoice_to' => 'sometimes|required',
            'customer_contact' => 'sometimes|required',
            'cust_po_number' => 'nullable|required',
            'cost_detail' => 'required',
            'attachment.*' => 'sometimes|nullable|mimes:jpg,jpeg,png,pdf|max:20000',
            'notes' => 'nullable',
            'transaction_code' => 'sometimes|required',
            'invoices' => 'sometimes|nullable',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
        ],
        [
            // 'attachment.*.required' => 'Please upload a file',
            'attachment.*.mimes' => 'Only jpeg, png and pdf images are allowed',
            'attachment.*.max' => 'Sorry! Maximum allowed size for a file is 20MB',
        ]);

        if ($formData['cost_detail']) {
            for ($i=0; $i<count($formData['cost_detail']); $i++) {
                $validatorCostDetail = Validator::make($formData['cost_detail'][$i], [
                    'cost_description' => 'required',
                    'quantity' => 'required|numeric|min:0|not_in:0',
                    'unit_of_measurement' => 'required|in:MEN,PCS,HRS,MT',
                    'unit_price' => 'required|numeric|min:0',
                    'GST_percentage' => 'numeric|min:0',
                    'currency' => 'required|in:USD,AUD',
                    'vat_amount' => 'required|numeric',
                    'sub_total' => 'required|numeric',
                    'total' => 'required|numeric',
                    'charge_to' => 'required|string'
                ]);
                if ($validatorCostDetail->fails()) {
                    $costDetailErrors['cost_detail_'.$i] = $validatorCostDetail->errors()->toArray();
                }
            }
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
        }

        if (isset($errors)) {
            $errMessageBag = $errors->toArray(); 
            if (isset($costDetailErrors)) {
                $errMessageBag['cost_detail'] = $costDetailErrors;
            }
            throw ValidationException::withMessages($errMessageBag);
        }

        $instruction = $this->instructionRepository->getById($formData['instruction_id']);
        if (!$instruction) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan']);
        }

        $updatedInstruction = $this->instructionRepository->save($formData);

        $storeVendorData = $this->vendorRepository->save(array_intersect_key($validator->validated(), array_flip(['assigned_vendor', 'vendor_address', 'invoice_to'])));
        if (!$storeVendorData) {
            throw ValidationException::withMessages(['ERROR VENDOR NOT AVAILABLE']);
        }

        return $updatedInstruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi draft
    */
    public function setDraft(string $instructionId) : Object
    {
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $draftInstruction = $this->instructionRepository->setInstructionStatus($instructionId, 'Draft');
        return $draftInstruction;
    }


    /** 
     * untuk mengubah status instruksi menjadi completed
    */
    public function setComplete(string $instructionId) : Object
    {
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $completedInstruction = $this->instructionRepository->setInstructionStatus($instructionId, 'Completed');
        return $completedInstruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi cancelled
    */
    public function setCancelled(array $formData) : Object
    {
        $validator = Validator::make($formData['termination'], [
            'termination_reason' => 'required|string|min:5',
            'attachment' => 'required|file'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $instruction = $this->instructionRepository->getById($formData['instruction_id']);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        //TODO: update instruction termination

        $cancelledInstruction = $this->instructionRepository->setInstructionStatus($formData['instruction_id'], 'Cancelled');
        return $cancelledInstruction;
    }

    /**
     * untuk menghapus data instruction
     */
    public function delete(string $instructionId) : string
    {
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }
        // $instructionId = $formData['instruction_id'];
        $this->instructionRepository->delete($instructionId);
        return $instructionId;
    }
}