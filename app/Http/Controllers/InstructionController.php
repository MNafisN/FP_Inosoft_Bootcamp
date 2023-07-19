<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Services\InstructionService;

class InstructionController extends Controller
{
    protected $instructionService;

    public function __construct(InstructionService $instructionService)
    {
        $this->middleware('auth:api');
        $this->instructionService = $instructionService;
    }

    protected function handleComplexError(Exception $err) 
    {
        // return $err->getTrace()[0]['args'][0];
        return $err->getTrace()[0];
    }

    public function exportExcel()
    {
        try {
            $instructions = $this->instructionService->exportExcel();
            return $instructions;
        } catch (Exception $err) {
            return response()->json([
                'status' => 404,
                'error' => $err->getMessage()
            ], 404);
        }
    }

    public function exportPdf(Request $request)
    {
        $data = $request->all();
        try {
            $instruction = $this->instructionService->exportPdf($data);
            return $instruction;
        } catch (Exception $err) {
            return response()->json([
                'status' => 404,
                'error' => $err->getMessage()
            ], 404);
        }
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $data = $request->all();
        try {
            return response()->json([
                'file' => $this->instructionService->uploadFile($data)
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 422);
        }
    }

    public function downloadFile(string $fileName)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->downloadFile($fileName)
            ];
            return $result['data'];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    public function deleteFile(string $fileName)
    {
        try {
            $result = [
                'status' => 200,
                'message' => $this->instructionService->deleteFile($fileName) . " Deleted Successfully"
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    // public function downloadAttachment(Request $request)
    // {
    //     // return response()->download(storage_path('/app/public/documents/instructions/LI-2023-0003/attachments/Project_Assignment_3_Backend (B5).pdf'), 'Project_Assignment_3_Backend (B5).pdf');
    //     $instructionId = $request->id;
    //     $fileName = $request->file_name;
    //     try {
    //         $result = [
    //             'status' => 200,
    //             'data' => $this->instructionService->downloadAttachment($instructionId, $fileName)
    //         ];
    //         return $result['data'];
    //     } catch (Exception $err) {
    //         $result = [
    //             'status' => 404,
    //             'error' => $err->getMessage()
    //         ];
    //     }
    //     return response()->json($result, $result['status']);
    // }

    // public function downloadInvoiceAttachment(Request $request)
    // {
    //     $instructionId = $request->id;
    //     $invoiceNumber = $request->invoice_no;
    //     $fileName = $request->file_name;
    //     try {
    //         $result = [
    //             'status' => 200,
    //             'data' => $this->instructionService->downloadInvoiceAttachment($instructionId, $invoiceNumber, $fileName)
    //         ];
    //         return $result['data'];
    //     } catch (Exception $err) {
    //         $result = [
    //             'status' => 404,
    //             'error' => $err->getMessage()
    //         ];
    //     }
    //     return response()->json($result, $result['status']);
    // }
    
    // public function downloadInvoiceSupportingDocument(Request $request)
    // {
    //     $instructionId = $request->id;
    //     $invoiceNumber = $request->invoice_no;
    //     $fileName = $request->file_name;
    //     try {
    //         $result = [
    //             'status' => 200,
    //             'data' => $this->instructionService->downloadInvoiceSupportingDocument($instructionId, $invoiceNumber, $fileName)
    //         ];
    //         return $result['data'];
    //     } catch (Exception $err) {
    //         $result = [
    //             'status' => 404,
    //             'error' => $err->getMessage()
    //         ];
    //     }
    //     return response()->json($result, $result['status']);
    // }

    // public function downloadTerminationAttachment(Request $request)
    // {
    //     $instructionId = $request->id;
    //     $fileName = $request->file_name;
    //     try {
    //         $result = [
    //             'status' => 200,
    //             'data' => $this->instructionService->downloadTerminationAttachment($instructionId, $fileName)
    //         ];
    //         return $result['data'];
    //     } catch (Exception $err) {
    //         $result = [
    //             'status' => 404,
    //             'error' => $err->getMessage()
    //         ];
    //     }
    //     return response()->json($result, $result['status']);
    // }

    // public function downloadInternalAttachment(Request $request)
    // {
    //     $instructionId = $request->id;
    //     $fileName = $request->file_name;
    //     try {
    //         $result = [
    //             'status' => 200,
    //             'data' => $this->instructionService->downloadInternalAttachment($instructionId, $fileName)
    //         ];
    //         return $result['data'];
    //     } catch (Exception $err) {
    //         $result = [
    //             'status' => 404,
    //             'error' => $err->getMessage()
    //         ];
    //     }
    //     return response()->json($result, $result['status']);
    // }

    /**
     * Menampilkan hasil dari fitur pencarian
     * 
     * @param  string $query
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInstruction(string $query) : JsonResponse
    {
        try {
            $instructions = $this->instructionService->getSearched($query);
            return response()->json([
                'status' => 200,
                'data' => $instructions
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 404,
                'error' => $err->getMessage()
            ], 404);
        }
    }

    /**
     * Tampilkan daftar instruksi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstructionList() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->getAll()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tampilkan daftar instruksi berstatus in progress
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstructionInProgressList() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->getInProgress()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tampilkan daftar instruksi berstatus draft
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstructionDraftList() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->getDraft()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tampilkan daftar instruksi berstatus draft dan in progress
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOpenInstructionList() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->getOpen()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tampilkan daftar instruksi berstatus cancelled dan completed
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompletedInstructionList() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->instructionService->getCompleted()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Sediakan data untuk halaman tambah instruksi baru
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewInstruction() : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'form_data' => $this->instructionService->getInstructionFormData()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }


    /**
     * Tambah instruksi baru
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInstruction(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->store($data, $request);
            return response()->json([
                'status' => 201,
                'message' => 'Instruction added successfully',
                'instruction' => $instruction
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Tampilkan detil instruksi
     */
    public function getInstructionDetail(string $id) : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'detail_instruction' => $this->instructionService->getInstructionDetail($id)
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tambah attachment instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInstructionAttachment(Request $request) : JsonResponse
    {
        $data = $request->all();
        // dd($request->attachment->isValid());

        try {
            $instruction = $this->instructionService->addAttachment($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction attachment added successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Hapus attachment instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInstructionAttachment(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->deleteAttachment($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction attachment deleted successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Tambah invoice instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInstructionInvoice(Request $request) : JsonResponse
    {
        $data = $request->all();
        // dd($request->invoice_supporting_document->isValid());

        try {
            $instruction = $this->instructionService->addInvoice($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction invoice added successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Perbarui invoice instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInstructionInvoice(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->updateInvoice($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction invoice updated successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Hapus invoice instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInstructionInvoice(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->deleteInvoice($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction invoice deleted successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Perbarui instruksi untuk menyimpan alasan dibatalkannya instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInstructionTermination(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->updateTermination($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction termination updated successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Sediakan data untuk halaman perbarui instruksi yang sudah ada
     *
     * @param  string $instructionId
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function editInstruction(string $instructionId) : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'current_data' => $this->instructionService->getById($instructionId),
                'form_data' => $this->instructionService->getInstructionFormData()
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'error' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Perbarui instruksi yang sudah ada
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInstruction(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $instruction = $this->instructionService->update($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction updated successfully',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Ubah status instruksi menjadi draft
     *
     * @param  string $instructionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToDraft(string $instructionId) : JsonResponse
    {
        try {
            $instruction = $this->instructionService->setDraft($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction status has been set to Draft',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Ubah status instruksi menjadi in progress
     *
     * @param  string $instructionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToInProgress(string $instructionId) : JsonResponse
    {
        try {
            $instruction = $this->instructionService->setInProgress($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction status has been set to In Progress',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Ubah status instruksi menjadi completed
     *
     * @param  string $instructionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToCompleted(string $instructionId) : JsonResponse
    {
        try {
            $instruction = $this->instructionService->setComplete($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction has been set to Completed',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Ubah status instruksi menjadi cancelled
     *
     * @param  string $instructionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToCancelled(string $instructionId) : JsonResponse
    {
        try {
            $instruction = $this->instructionService->setCancelled($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction has been set to Cancelled',
                'instruction' => $instruction
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }


    /**
     * Hapus instruksi
     *
     * @param  string $instructionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInstruction(string $instructionId) : JsonResponse
    {
        try {
            $instruction = $this->instructionService->delete($instructionId);
            return response()->json([
                'status' => 200,
                'message' => $instruction." Deleted successfully"
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
    }

    /**
     * Tampilkan data internal
     *
     * @param  string $instructionId
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInternalData(string $instructionId) : JsonResponse
    {
        try {
            $result = [
                'status' => 200,
                'internal_data' => $this->instructionService->getInternal($instructionId)
            ];
        } catch (Exception $err) {
            $result = [
                'status' => 404,
                'message' => $err->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Tambah attachment internal
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInternalAttachment(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $internal = $this->instructionService->addInternalAttachment($data, $request);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction internal attachment added successfully',
                'internal_data' => $internal
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Hapus attachment internal
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInternalAttachment(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $internal = $this->instructionService->deleteInternalAttachment($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction internal attachment deleted successfully',
                'internal_data' => $internal
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Tambah internal note instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addInternalNote(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $internal = $this->instructionService->addInternalNotes($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction internal notes added successfully',
                'internal_data' => $internal
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Perbarui internal note instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInternalNote(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $internal = $this->instructionService->updateInternalNotes($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction internal notes updated successfully',
                'internal_data' => $internal
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }

    /**
     * Hapus internal note instruksi
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteInternalNote(Request $request) : JsonResponse
    {
        $data = $request->all();

        try {
            $internal = $this->instructionService->deleteInternalNotes($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction internal notes deleted successfully',
                'internal_data' => $internal
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $this->handleComplexError($err)
            ], 422);
        }
    }
}
