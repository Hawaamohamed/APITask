<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
  
Route::prefix('v1')->group(function(){
    
    //users
    Route::post('/users/login', [App\Http\Controllers\API\V1\UsersAPIController::class, 'login']);
    Route::post('/users/register', [App\Http\Controllers\API\V1\UsersAPIController::class, 'register']);
    Route::get('/users/logout', [App\Http\Controllers\API\V1\UsersAPIController::class, 'logout']);
     
    
    Route::middleware('auth:api')->group(function () {

    Route::prefix('annualEvaluationFeet')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\AnnualEvaluationFeetAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\AnnualEvaluationFeetAPIController::class, 'store']);

    });
 

    Route::prefix('earlyComplication')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\EarlyComplicationAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\EarlyComplicationAPIController::class, 'store']);

    });

    Route::prefix('geneticDisease')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\GeneticDiseaseAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\GeneticDiseaseAPIController::class, 'store']);

    });

    Route::prefix('lateComplication')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\LateComplicationAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\LateComplicationAPIController::class, 'store']);

    });

    Route::prefix('medicalExamination')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\MedicalExaminationAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\MedicalExaminationAPIController::class, 'store']);

    });

    Route::prefix('newCase')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\NewCaseAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\NewCaseAPIController::class, 'store']);

    });

    Route::prefix('patients')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\PatientAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\PatientAPIController::class, 'store']);

    });

    Route::prefix('patientDisease')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\PatientDiseaseAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\PatientDiseaseAPIController::class, 'store']);

    });

    Route::prefix('patientFollowUp')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\PatientFollowUpAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\PatientFollowUpAPIController::class, 'store']);

    });

    Route::prefix('pharmaceutical')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\PharmaceuticalAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\PharmaceuticalAPIController::class, 'store']);

    });

    Route::prefix('previousAnalysis')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\PreviousAnalysisAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\PreviousAnalysisAPIController::class, 'store']);

    });

    Route::prefix('procedureForPatient')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\ProcedureForPatientAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\ProcedureForPatientAPIController::class, 'store']);

    });

    Route::prefix('riskFactor')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\RiskFactorAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\RiskFactorAPIController::class, 'store']);

    });

    Route::prefix('staff')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\StaffAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\StaffAPIController::class, 'store']);

    });

    Route::prefix('staffSalary')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\StaffSalaryAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\StaffSalaryAPIController::class, 'store']);

    });

    Route::prefix('visit')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\VisitAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\VisitAPIController::class, 'store']);

    });

    Route::prefix('discounts')->group(function(){
        Route::get('/', [App\Http\Controllers\API\V1\DiscountAPIController::class, 'index']);
        Route::post('/add', [App\Http\Controllers\API\V1\DiscountAPIController::class, 'store']);

    });
 
   
  
  });


});