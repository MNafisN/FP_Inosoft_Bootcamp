<?php

namespace App\Services;

use App\Repositories\InstructionRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\VendorRepository;
use App\Repositories\InternalRepository;
use App\Repositories\AttachmentRepository;

use Illuminate\Http\Request;
use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Carbon;

class InstructionService
{
    protected $instructionRepository;
    protected $customerRepository;
    protected $vendorRepository;
    protected $transactionRepository;
    protected $internalRepository;
    protected $attachmentRepository;

    public function __construct(
            InstructionRepository $instructionRepository,
            CustomerRepository $customerRepository,
            TransactionRepository $transactionRepository,
            VendorRepository $vendorRepository,
            InternalRepository $internalRepository,
            AttachmentRepository $attachmentRepository
        )
    {
        $this->instructionRepository = $instructionRepository;
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
        $this->vendorRepository = $vendorRepository;
        $this->internalRepository = $internalRepository;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function exportExcel()
    {
        $instructions = $this->instructionRepository->export();
        return $instructions;
    }

    public function exportPdf($data)
    {
        $instruction = $this->instructionRepository->exportPdf($data);
        return $instruction;
    }

    public function uploadFile(array $data)
    {
        $validator = Validator::make($data, [
            'attachment' => 'required|mimes:jpg,jpeg,png,pdf|max:20000',
        ],
        [
            'attachment.required' => 'Please upload a file',
            'attachment.mimes' => 'Only jpeg, png and pdf images are allowed',
            'attachment.max' => 'Sorry! Maximum allowed size for a file is 20MB',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['posted_by'] = auth()->user()['username'];
        $data['file_name'] = pathinfo($data['attachment']->getClientOriginalName(), PATHINFO_FILENAME) . date('YmdHis') . "." . $data['attachment']->getClientOriginalExtension();
        $attachment = $this->attachmentRepository->saveNew($data);

        return $attachment;
    }

    public function downloadFile(string $fileName)
    {
        $fileDecoder = rawurldecode($fileName);
        $attachment = $this->attachmentRepository->getByName($fileDecoder);
        if (!$attachment) {
            throw new InvalidArgumentException('File not found');
        }
        $file = $this->attachmentRepository->download($fileDecoder);
        return $file;
    }

    public function deleteFile(string $fileName): string
    {
        $fileDecoder = rawurldecode($fileName);
        $attachment = $this->attachmentRepository->getByName($fileDecoder);
        if (!$attachment) {
            throw new InvalidArgumentException('File not found');
        }
        // dd($attachment->file_name);
        $this->attachmentRepository->delete($attachment->file_name);
        return $attachment->file_name;
    }

    // public function downloadAttachment(string $instructionId, string $fileName)
    // {
    //     $idDecoder = rawurldecode($instructionId);
    //     $fileDecoder = rawurldecode($fileName);
    //     $instruction = $this->instructionRepository->getById($idDecoder);
    //     if (!$instruction) {
    //         throw new InvalidArgumentException('Data instruksi tidak ditemukan');
    //     }

    //     $file = $this->instructionRepository->downloadAttachment($idDecoder, '/attachments/', $fileDecoder);
    //     // if (!$file) {
    //     //     throw new InvalidArgumentException();
    //     // }
    //     return $file;
    // }

    // public function downloadInvoiceAttachment(string $instructionId, string $invoiceNumber, string $fileName)
    // {
    //     $idDecoder = rawurldecode($instructionId);
    //     $invoiceDecoder = rawurldecode($invoiceNumber);
    //     $fileDecoder = rawurldecode($fileName);
    //     $instruction = $this->instructionRepository->getById($idDecoder);
    //     if (!$instruction) {
    //         throw new InvalidArgumentException('Data instruksi tidak ditemukan');
    //     }

    //     $file = $this->instructionRepository->downloadAttachment($idDecoder, "/invoices/" . $invoiceDecoder . "/", $fileDecoder);
    //     return $file;
    // }

    // public function downloadInvoiceSupportingDocument(string $instructionId, string $invoiceNumber, string $fileName)
    // {
    //     $idDecoder = rawurldecode($instructionId);
    //     $invoiceDecoder = rawurldecode($invoiceNumber);
    //     $fileDecoder = rawurldecode($fileName);
    //     $instruction = $this->instructionRepository->getById($idDecoder);
    //     if (!$instruction) {
    //         throw new InvalidArgumentException('Data instruksi tidak ditemukan');
    //     }

    //     $file = $this->instructionRepository->downloadAttachment($idDecoder, "/invoices/" . $invoiceDecoder . "/supporting_document/", $fileDecoder);
    //     return $file;
    // }

    // public function downloadTerminationAttachment(string $instructionId, string $fileName)
    // {
    //     $idDecoder = rawurldecode($instructionId);
    //     $fileDecoder = rawurldecode($fileName);
    //     $instruction = $this->instructionRepository->getById($idDecoder);
    //     if (!$instruction) {
    //         throw new InvalidArgumentException('Data instruksi tidak ditemukan');
    //     }

    //     $file = $this->instructionRepository->downloadAttachment($idDecoder, '/termination_attachment/', $fileDecoder);
    //     return $file;
    // }

    // public function downloadInternalAttachment(string $instructionId, string $fileName)
    // {
    //     $idDecoder = rawurldecode($instructionId);
    //     $fileDecoder = rawurldecode($fileName);
    //     $instruction = $this->instructionRepository->getById($idDecoder);
    //     if (!$instruction) {
    //         throw new InvalidArgumentException('Data instruksi tidak ditemukan');
    //     }

    //     $file = $this->internalRepository->downloadAttachment($idDecoder, $fileDecoder);
    //     return $file;
    // }

    /**
     * untuk menyimpan log instruksi pada internal only
     */
    protected function storeActivity(string $instructionId, string $action) : void
    {
        $activity['instruction_id'] = $instructionId;
        $activity['action'] = $action;
        $activity['by'] = auth()->user()['username'];
        $activity['date'] = (string)Carbon::now('+7:00');
        $this->internalRepository->storeLog($activity);
    }

    /**
     * untuk mengambil list instruction berdasarkan hasil pencarian
     */
    public function getSearched(string $query) : ?Object
    {
        $queryDecoder = rawurldecode($query);
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
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
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
    public function store(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            // 'instruction_id' => 'required|string|unique:App\Models\Instruction,instruction_id',
            'instruction_type' => 'required|string',
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'nullable|string',
            'invoice_to' => 'sometimes|required',
            'customer_contact' => 'sometimes|required',
            'cust_po_number' => 'nullable|required',
            'cost_detail' => 'required',
            'attachment.*' => 'sometimes|nullable',
            'notes' => 'nullable',
            'transaction_code' => 'sometimes|required',
            'invoices' => 'sometimes|nullable',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
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

        if (empty($formData['attachment']) == false) {
            $document = $request->attachment;
            foreach ($formData['attachment'] as $key => $file) {
                // $formData['attachment'][$key] = $document[$key];
                $formData['file_name'][$key] = $document[$key];
                $formData['file_name'][$key]['posted_by'] = auth()->user()['username'];
                $formData['file_name'][$key]['created_at'] = (string)Carbon::now('+7:00');
            }
        }

        $formData['issued_by'] = auth()->user()['username'];
        $formData['date_of_issue'] = (string)Carbon::now('+7:00')->format('d/m/Y');

        $newInstruction = $this->instructionRepository->save($formData);

        $storeVendorData = $this->vendorRepository->save(array_intersect_key($validator->validated(), array_flip(['assigned_vendor', 'vendor_address', 'invoice_to'])));
        if (!$storeVendorData) {
            throw ValidationException::withMessages(['ERROR VENDOR NOT AVAILABLE']);
        }

        $this->getInternal($newInstruction->instruction_id);
        $this->storeActivity($newInstruction->instruction_id, '3rd Party Instruction Created');

        return $newInstruction;
    }

    /**
     * untuk mengambil detil data sebuah instruksi
     */
    public function getInstructionDetail(string $id) : ?Object
    {
        $instructionId = rawurldecode($id);        
        $instruction = $this->instructionRepository->getById($instructionId);
        if (!$instruction) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan']);
        }
        return $instruction;
    }

    /**
     * untuk menambah attachment instruksi
     */
    public function addAttachment(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'attachment' => 'required',
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

        $formData['file_name'] = $formData['attachment'];
        $formData['file_name']['posted_by'] = auth()->user()['username'];
        $formData['file_name']['created_at'] = (string)Carbon::now('+7:00');

        $updatedInstruction = $this->instructionRepository->saveAttachment($formData, 'store');
        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, "A 3rd Party Instruction Attachment '" . $formData['attachment']['name'] . "' Uploaded");
        return $updatedInstruction;
    }

    /**
     * untuk menghapus attachment instruksi
     */
    public function deleteAttachment(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
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

        $updatedInstruction = $this->instructionRepository->saveAttachment($formData, 'delete');
        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, 'A 3rd Party Instruction Attachment Deleted');
        return $updatedInstruction;
    }

    /**
     * untuk menambah vendor invoice instruksi
     */
    public function addInvoice(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'invoice_number' => 'required|string',
            'invoice_attachment' => 'required',
            'invoice_supporting_document.*' => 'sometimes|nullable',
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

        $formData['invoice_attachment_name'] = $formData['invoice_attachment'];
        $formData['invoice_attachment_name']['posted_by'] = auth()->user()['username'];
        $formData['invoice_attachment_name']['created_at'] = (string)Carbon::now('+7:00');

        if (empty($formData['invoice_supporting_document']) == false) {
            $document = $request->invoice_supporting_document;
            foreach ($formData['invoice_supporting_document'] as $key => $file) {
                // $formData['attachment'][$key] = $document[$key];
                $formData['invoice_supporting_document_name'][$key] = $document[$key];
                $formData['invoice_supporting_document_name'][$key]['posted_by'] = auth()->user()['username'];
                $formData['invoice_supporting_document_name'][$key]['created_at'] = (string)Carbon::now('+7:00');
            }
        }

        $updatedInstruction = $this->instructionRepository->saveInvoice($formData, 'store');
        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, "3rd Party Instruction Vendor Invoice Number '" . $formData['invoice_number'] . "' Added");
        return $updatedInstruction;
    }

    /**
     * untuk memperbarui vendor invoice instruksi
     */
    public function updateInvoice(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
            'invoice_number' => 'required|string',
            'invoice_attachment' => 'required',
            'invoice_supporting_document.*' => 'sometimes|nullable',
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

        $formData['invoice_attachment_name'] = $formData['invoice_attachment'];
        $formData['invoice_attachment_name']['posted_by'] = auth()->user()['username'];
        $formData['invoice_attachment_name']['created_at'] = (string)Carbon::now('+7:00');

        if (empty($formData['invoice_supporting_document']) == false) {
            $document = $request->invoice_supporting_document;
            foreach ($formData['invoice_supporting_document'] as $key => $file) {
                // $formData['attachment'][$key] = $document[$key];
                $formData['invoice_supporting_document_name'][$key] = $document[$key];
                $formData['invoice_supporting_document_name'][$key]['posted_by'] = auth()->user()['username'];
                $formData['invoice_supporting_document_name'][$key]['created_at'] = (string)Carbon::now('+7:00');
            }
        }

        $updatedInstruction = $this->instructionRepository->saveInvoice($formData, 'update');
        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, "3rd Party Instruction Vendor Invoice Number '" . $formData['invoice_number'] . "' Modified");
        return $updatedInstruction;
    }

    /**
     * untuk menghapus vendor invoice instruksi
     */
    public function deleteInvoice(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
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

        $updatedInstruction = $this->instructionRepository->saveInvoice($formData, 'delete');
        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, "A 3rd Party Instruction Invoice Vendor Removed");
        return $updatedInstruction;
    }

    /**
     * untuk memperbarui keterangan dibatalkannya instruksi
     */
    public function updateTermination(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'termination_reason' => 'required|string',
            'attachment.*' => 'sometimes|nullable',
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

        if (empty($formData['attachment']) == false) {
            $document = $request->attachment;
            foreach ($formData['attachment'] as $key => $file) {
                // $formData['attachment'][$key] = $document[$key];
                $formData['file_name'][$key] = $document[$key];
                $formData['file_name'][$key]['posted_by'] = auth()->user()['username'];
                $formData['file_name'][$key]['created_at'] = (string)Carbon::now('+7:00');
            }
        }

        $updatedInstruction = $this->instructionRepository->saveTermination($formData, auth()->user()['username']);
        return $updatedInstruction;
    }

    /**
     * untuk memodifikasi data instruction yang sudah ada
     */
    public function update(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'assigned_vendor' => 'required',
            'vendor_address' => 'required',
            'attention_of' => 'required|string',
            'quotation_number' => 'nullable|string',
            'invoice_to' => 'sometimes|required',
            'customer_contact' => 'sometimes|required',
            'cust_po_number' => 'nullable|required',
            'cost_detail' => 'required',
            'attachment.*' => 'sometimes|nullable',
            'notes' => 'nullable',
            'transaction_code' => 'sometimes|required',
            'invoices' => 'sometimes|nullable',
            'termination' => 'sometimes|nullable',
            'instruction_status' => 'required'
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

        if (empty($formData['attachment']) == false) {
            $document = $request->attachment;
            foreach ($formData['attachment'] as $key => $file) {
                // $formData['attachment'][$key] = $document[$key];
                $formData['file_name'][$key] = $document[$key];
                $formData['file_name'][$key]['posted_by'] = auth()->user()['username'];
                $formData['file_name'][$key]['created_at'] = (string)Carbon::now('+7:00');
            }
        } else { $formData['file_name'] = null; }

        $updatedInstruction = $this->instructionRepository->save($formData);

        $storeVendorData = $this->vendorRepository->save(array_intersect_key($validator->validated(), array_flip(['assigned_vendor', 'vendor_address', 'invoice_to'])));
        if (!$storeVendorData) {
            throw ValidationException::withMessages(['ERROR VENDOR NOT AVAILABLE']);
        }

        $this->getInternal($updatedInstruction->instruction_id);
        $this->storeActivity($updatedInstruction->instruction_id, "3rd Party Instruction Modified");

        return $updatedInstruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi draft
    */
    public function setDraft(string $instructionId) : Object
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $draftInstruction = $this->instructionRepository->setInstructionStatus($instructionId, 'Draft');
        return $draftInstruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi in progress
    */
    public function setInProgress(string $instructionId) : Object
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $instruction = $this->instructionRepository->setInstructionStatus($instructionId, 'In Progress');
        return $instruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi completed
    */
    public function setComplete(string $instructionId) : Object
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $invoices = $instruction->invoices;
        if (is_countable($invoices) && count($invoices) > 0) {
            $completedInstruction = $this->instructionRepository->setInstructionStatus($instructionId, 'Completed');
        } else {
            throw new InvalidArgumentException('Belum ada vendor invoice yang dapat diterima');
        }

        $this->getInternal($completedInstruction->instruction_id);
        $this->storeActivity($completedInstruction->instruction_id, "Receive All Invoice 3rd Party Instruction");

        return $completedInstruction;
    }

    /** 
     * untuk mengubah status instruksi menjadi cancelled
    */
    public function setCancelled(string $instructionId) : Object
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $termination = $instruction->termination;
        if (is_countable($termination) && count($termination) > 0) {
            $cancelledInstruction = $this->instructionRepository->setInstructionStatus($instructionId, 'Cancelled');
        } else {
            throw new InvalidArgumentException('Alasan pembatalan belum ada');
        }

        $this->getInternal($cancelledInstruction->instruction_id);
        $this->storeActivity($cancelledInstruction->instruction_id, "3rd Party Instruction Cancelled");

        return $cancelledInstruction;
    }

    /**
     * untuk menghapus data instruction
     */
    public function delete(string $instructionId) : string
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }
        // $instructionId = $formData['instruction_id'];
        $this->instructionRepository->delete($instructionId);
        $this->internalRepository->delete($instructionId);
        return $instructionId;
    }

    /**
     * untuk mengambil data internal sesuai dengan instruksi yang ditampilkan
     */
    public function getInternal(string $instructionId) : ?Object
    {
        $idDecoder = rawurldecode($instructionId);
        $instruction = $this->instructionRepository->getById($idDecoder);
        if (!$instruction) {
            throw new InvalidArgumentException('Data instruksi tidak ditemukan');
        }

        $internal = $this->internalRepository->getById($instructionId);
        if (!$internal) {
            $internal = $this->internalRepository->saveNew($instructionId);
        }

        return $internal;
    }

    /**
     * untuk menambah attachment internal instruksi
     */
    public function addInternalAttachment(array $formData, Request $request) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'attachment' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $internal = $this->internalRepository->getById($formData['instruction_id']);
        if (!$internal) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan, attachment internal tidak dapat disimpan']);
        }

        $formData['file_name'] = $formData['attachment'];
        $formData['posted_by'] = auth()->user()['username'];
        $updatedInternal = $this->internalRepository->saveAttachment($formData, 'store');
        return $updatedInternal;
    }

    /**
     * untuk menghapus attachment instruksi
     */
    public function deleteInternalAttachment(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $internal = $this->internalRepository->getById($formData['instruction_id']);
        if (!$internal) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan, attachment internal tidak dapat dihapus']);
        }

        $updatedInternal = $this->internalRepository->saveAttachment($formData, 'delete');
        return $updatedInternal;
    }

    /**
     * untuk menambah internal notes dari sebuah instruksi
     */
    public function addInternalNotes(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $internal = $this->internalRepository->getById($formData['instruction_id']);
        if (!$internal) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan, note internal tidak dapat ditambahkan']);
        }

        try {
            $formData['posted_by'] = auth()->user()['username'];
            $updatedInternal = $this->internalRepository->saveNotes($formData, 'store');
        } catch (Exception $err) {
            throw ValidationException::withMessages([$err->getMessage()]);
        }

        return $updatedInternal;
    }

    /**
     * untuk memperbarui internal notes dari sebuah instruksi
     */
    public function updateInternalNotes(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
            'note' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $internal = $this->internalRepository->getById($formData['instruction_id']);
        if (!$internal) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan, note internal tidak dapat disunting']);
        }

        try {
            $formData['posted_by'] = auth()->user()['username'];
            $updatedInternal = $this->internalRepository->saveNotes($formData, 'update');
        } catch (Exception $err) {
            throw ValidationException::withMessages([$err->getMessage()]);
        }
        return $updatedInternal;
    }

    /**
     * untuk menghapus internal notes instruksi
     */
    public function deleteInternalNotes(array $formData) : Object
    {
        $validator = Validator::make($formData, [
            'instruction_id' => 'required|string',
            'index' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errMessageBag = $errors->toArray(); 
            throw ValidationException::withMessages($errMessageBag);
        }

        $internal = $this->internalRepository->getById($formData['instruction_id']);
        if (!$internal) {
            throw ValidationException::withMessages(['Data instruksi tidak ditemukan, note internal tidak dapat dihapus']);
        }

        try {
            $formData['posted_by'] = auth()->user()['username'];
            $updatedInternal = $this->internalRepository->saveNotes($formData, 'delete');
        } catch (Exception $err) {
            throw ValidationException::withMessages([$err->getMessage()]);
        }
        return $updatedInternal;
    }
}