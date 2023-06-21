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
            $instruction = $this->instructionService->store($data);
            return response()->json([
                'status' => 201,
                'message' => 'Instruction added successfully',
                'instruction' => $instruction
            ], 201);
        } catch (Exception $err) {
            return response()->json([
                'status' => 422,
                'error' => $err->getMessage()
            ], 422);
        }
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
            $instruction = $this->instructionService->update($data);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction updated successfully',
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
                'message' => 'Instruction updated successfully',
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToCompleted(string $instructionId) : JsonResponse
    {
        // $data = $request->all();

        try {
            $instruction = $this->instructionService->setComplete($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction updated successfully',
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setInstructionToCancelled(string $instructionId) : JsonResponse
    {
        // $data = $request->all();

        try {
            $instruction = $this->instructionService->setCancelled($instructionId);
            return response()->json([
                'status' => 200,
                'message' => 'Instruction updated successfully',
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
}
