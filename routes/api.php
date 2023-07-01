<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructionController;
use App\Models\Instruction;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('data', [AuthController::class, 'data']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group([
    'prefix' => 'instruction',
    // 'middleware' => 'auth:api'
], function () {
    Route::get('download/{id}/{file_name}', [InstructionController::class, 'downloadAttachment']);
    Route::get('download/{id}/invoice/{invoice_no}/{file_name}', [InstructionController::class, 'downloadInvoiceAttachment']);
    Route::get('download/{id}/invoice/supporting/{invoice_no}/{file_name}', [InstructionController::class, 'downloadInvoiceSupportingDocument']);
    Route::get('download/{id}/termination/{file_name}', [InstructionController::class, 'downloadTerminationAttachment']);
    Route::get('download/{id}/internal/{file_name}', [InstructionController::class, 'downloadInternalAttachment']);

    Route::get('search/{query}', [InstructionController::class, 'searchInstruction']);              // Tampilkan list instruksi hasil search

    Route::get('list', [InstructionController::class, 'getInstructionList']);
    Route::get('list/inProgress', [InstructionController::class, 'getInstructionInProgressList']);
    Route::get('list/draft', [InstructionController::class, 'getInstructionDraftList']);
    Route::get('list/open', [InstructionController::class, 'getOpenInstructionList']);              // Tampilkan list instruksi Open
    Route::get('list/completed', [InstructionController::class, 'getCompletedInstructionList']);    // Tampilkan list instruksi Completed

    Route::get('addNew', [InstructionController::class, 'addNewInstruction']);                      // Penyedia data untuk form tambah instruksi baru
    Route::post('add', [InstructionController::class, 'addInstruction']);                           // Aksi untuk simpan data form instruksi baru

    Route::get('{id}', [InstructionController::class, 'getInstructionDetail']);                     // Penyedia data tampilkan detail instruksi

    Route::put('addAttachment', [InstructionController::class, 'addInstructionAttachment']);        // Aksi untuk menambah attachment sebuah instruksi di halaman detail instruksi
    Route::put('deleteAttachment', [InstructionController::class, 'deleteInstructionAttachment']);  // Aksi untuk menghapus attachment sebuah instruksi di halaman detail instruksi
    Route::put('addInvoice', [InstructionController::class, 'addInstructionInvoice']);              // Aksi untuk menambah invoice sebuah instruksi di halaman detail instruksi
    Route::put('updateInvoice', [InstructionController::class, 'updateInstructionInvoice']);        // Aksi untuk menyunting invoice sebuah instruksi di halaman detail instruksi
    Route::put('deleteInvoice', [InstructionController::class, 'deleteInstructionInvoice']);        // Aksi untuk menghapus invoice sebuah instruksi di halaman detail instruksi
    Route::put('addTermination', [InstructionController::class, 'addInstructionTermination']);      // Aksi untuk simpan alasan instruksi dibatalkan/cancelled

    Route::get('edit/{id}', [InstructionController::class, 'editInstruction']);                     // Penyedia data untuk form modify instruksi yang sudah ada
    Route::put('update', [InstructionController::class, 'updateInstruction']);                      // Aksi untuk simpan perubahan data form instruksi

    Route::put('saveAsDraft/{id}', [InstructionController::class, 'setInstructionToDraft']);        // Set status instruksi sebagai Draft
    Route::put('inProgress/{id}', [InstructionController::class, 'setInstructionToInProgress']);    // Set status instruksi sebagai In Progress
    Route::put('completed/{id}', [InstructionController::class, 'setInstructionToCompleted']);      // Set status instruksi sebagai Completed, dengan syarat invoice sudah ada
    Route::put('terminate/{id}', [InstructionController::class, 'setInstructionToCancelled']);      // Set status instruksi sebagai Cancelled, dengan syarat termination sudah ada

    Route::delete('delete/{id}', [InstructionController::class, 'deleteInstruction']);              // Hapus instruksi dengan parameter id instruksi di URI

    Route::group([
        'prefix' => 'internal'
    ], function () {
        Route::get('{id}', [InstructionController::class, 'getInternalData']);                      // Tampilkan data internal only sebuah instruksi
        Route::put('addAttachment', [InstructionController::class, 'addInternalAttachment']);       // Aksi untuk menambah attachment internal only
        Route::put('deleteAttachment', [InstructionController::class, 'deleteInternalAttachment']); // Aksi untuk menghapus attachment internal only
        Route::put('addNote', [InstructionController::class, 'addInternalNote']);                   // Aksi untuk menambah note internal only
        Route::put('updateNote', [InstructionController::class, 'updateInternalNote']);             // Aksi untuk menyunting note, syarat hanya user terkait yang diperbolehkan
        Route::put('deleteNote', [InstructionController::class, 'deleteInternalNote']);             // Aksi untuk menghapus note, syarat hanya user terkait yang diperbolehkan
    });
});
