<?php

namespace App\Repositories;

use App\Models\Instruction;
use Illuminate\Support\Facades\Storage;
use App\Exports\InstructionExport;

class InstructionRepository
{
    protected $instruction;

    public function __construct(Instruction $instruction)
    {
        $this->instruction = $instruction;
    }

    /**
     * untuk export file excel daftar instruksi
     */
    public function export()
    {
        return (new InstructionExport)->download('instructions.xlsx');
    }

    /**
     * untuk download file attachments
     */
    public function downloadAttachment(string $instructionId, string $path, string $fileName)
    {
        return Storage::download("/documents/instructions/" . substr($instructionId, 0, 12) . $path . $fileName, $fileName);
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
     * untuk mengambil semua list instruksi dengan status tertentu
     */
    public function getStatus(string $status) : Object
    {
        $instructions = $this->instruction->where('instruction_status', $status)->get();
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
            $revision = substr($data['instruction_id'], -3);
            $revisionNumber = substr($revision, -2);
            if (str_contains($revision, 'R')) {
                $revisionNumber++;
                if ($revisionNumber < 10) {
                    $revision = " R0" . $revisionNumber;
                } else {
                    $revision = " R" . $revisionNumber;
                }
            }
            else { 
                $revision = " R01";
            }
            $instruction->instruction_id = substr($data['instruction_id'], 0, 12) . $revision;
        } else {
            $instruction = new $this->instruction;

            if ($data['instruction_type'] == "Logistic Instruction") { $instruction->nextLId(); }
            else if ($data['instruction_type'] == "Service Instruction") { $instruction->nextSId(); }
            // $instruction->instruction_id = $data['instruction_id'];
            $instruction->instruction_type = $data['instruction_type'];    
        }

        $instruction->assigned_vendor = $data['assigned_vendor'];
        $instruction->vendor_address = $data['vendor_address'];
        $instruction->attention_of = $data['attention_of'];
        $instruction->quotation_number = $data['quotation_number'];
        $instruction->invoice_to = $data['invoice_to'];
        $instruction->customer_contact = $data['customer_contact'];
        $instruction->cust_po_number = $data['cust_po_number'];
        $instruction->cost_detail = $data['cost_detail'];

        if (array_key_exists('instruction_id', $data)) {
            foreach ($data['attachment'] as $key => $file) {
                $data['attachment'][$key]->storeAs("/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/attachments", $data['file_name'][$key]);
            }
        } else {
            foreach ($data['attachment'] as $key => $file) {
                $data['attachment'][$key]->storeAs("/documents/instructions/" . $instruction->instruction_id . "/attachments", $data['file_name'][$key]);
            }
        }

        $instruction->attachment = $data['file_name'];
        $instruction->notes = $data['notes'];
        $instruction->transaction_code = $data['transaction_code'];
        $instruction->invoices = $data['invoices'];
        $instruction->termination = $data['termination'];
        $instruction->instruction_status = $data['instruction_status'];

        $instruction->save();
        return $instruction->fresh();
    }
    
    /**
     * untuk menyimpan daftar attachment sebuah instruksi
     */
    public function saveAttachment(array $data, string $action) : Object 
    {
        $instruction = $this->getById($data['instruction_id']);
        $attachmentList = $instruction->attachment;

        if ($action == 'store') {
            // Storage::putFile("/documents/instructions/" . $data['instruction_id'] . "/" . $data['file_name'], $data['attachment'],);
            $data['attachment']->storeAs("/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/attachments", $data['file_name']);
            $attachmentList[] = $data['file_name'];
        } else if ($action == 'delete') {
            array_splice($attachmentList, $data['index'], 1);
        }
        
        $instruction->attachment = $attachmentList;

        $instruction->save();
        return $instruction->fresh();
    }

    /**
     * untuk menyimpan daftar invoice sebuah instruksi
     */
    public function saveInvoice(array $data, string $action) : Object 
    {
        $instruction = $this->getById($data['instruction_id']);
        $invoiceList = $instruction->invoices;

        if ($action == 'delete') {
            array_splice($invoiceList, $data['index'], 1);
        } else {
            $invoice['invoice_number'] = $data['invoice_number'];
            $invoice['invoice_attachment'] = $data['invoice_attachment']->getClientOriginalName();
            if (isset($data['invoice_supporting_document'])) {
                $invoice['invoice_supporting_document'] = $data['invoice_supporting_document']->getClientOriginalName();
            } else { $invoice['invoice_supporting_document'] = $data['invoice_supporting_document']; }

            if ($action == 'store') {
                $invoiceList[] = $invoice;
            } else if ($action == 'update') {
                $invoiceList[$data['index']] = $invoice;
            }

            $data['invoice_attachment']->storeAs(
                "/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/invoices/" . $data['invoice_number'],
                $data['invoice_attachment']->getClientOriginalName()
            );
            if (isset($invoice['invoice_supporting_document'])) {
                $data['invoice_supporting_document']->storeAs(
                    "/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/invoices/" . $data['invoice_number'] . "/supporting_document",
                    $data['invoice_supporting_document']->getClientOriginalName()
                );
            }
        }
        
        $instruction->invoices = $invoiceList;
        $instruction->save();
        return $instruction->fresh();
    }

    /**
     * untuk menyimpan keterangan dibatalkannya sebuah instruksi
     */
    public function saveTermination(array $data, string $by) : Object 
    {
        $instruction = $this->getById($data['instruction_id']);
        $termination['canceled_by'] = $by;
        $termination['termination_reason'] = $data['termination_reason'];
        $data['attachment']->storeAs(
            "/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/termination_attachment",
            $data['file_name']
        );
        $termination['attachment'] = $data['file_name'];

        $instruction->termination = $termination;
        $instruction->save();
        return $instruction->fresh();
    }

    /** 
     * untuk mengubah status suatu instruksi dalam database
    */
    public function setInstructionStatus(string $instructionId, string $status) : Object
    {
        $instruction = $this->getById($instructionId);
        $instruction->instruction_status = $status;
        $instruction->save();
        return $instruction->fresh();
    }

    /**
     * untuk menghapus data instruksi berdasarkan id
     */
    public function delete(string $instructionId) : void
    {
        $this->instruction->where('instruction_id', $instructionId)->delete();
    }
}