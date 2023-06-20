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
], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('data', [AuthController::class, 'data']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group([
    'prefix' => 'instruction',
    'middleware' => 'auth:api'
], function() {
    Route::get('search/{query}', [InstructionController::class, 'searchInstruction']);
    
    Route::get('list', [InstructionController::class, 'getInstructionList']);
    Route::get('list/inProgress', [InstructionController::class, 'getInstructionInProgressList']);
    Route::get('list/draft', [InstructionController::class, 'getInstructionDraftList']);
    Route::get('list/completed', [InstructionController::class, 'getCompletedInstructionList']);
    Route::post('add', [InstructionController::class, 'addInstruction']);

    Route::get('{id}', [InstructionController::class, 'getInstructionDetail']);
    Route::get('edit/{id}', [InstructionController::class, 'editInstruction']);
    Route::put('update', [InstructionController::class, 'updateInstruction']);
    Route::put('draft/{id}', [InstructionController::class, 'setInstructionToDraft']);
    Route::put('completed/{id}', [InstructionController::class, 'setInstructionToCompleted']);
    Route::put('terminate/{id}', [InstructionController::class, 'setInstructionToCancelled']);

    Route::delete('delete/{id}', [InstructionController::class, 'deleteInstruction']);
});