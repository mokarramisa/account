<?php

use App\Http\Controllers\Analysis\ComparisonChartController;
use App\Http\Controllers\Analysis\DataAnalysisController;
use App\Http\Controllers\Analysis\FinantialReportsAnalysisController;
use App\Http\Controllers\Analysis\IncomeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data-analysis', [DataAnalysisController::class, 'analysis']);

Route::get('/compare-charts', [ComparisonChartController::class, 'compare']);

Route::get('/finantial-reposrts', [FinantialReportsAnalysisController::class, 'reports']);

Route::get('/compare-income', [IncomeController::class, 'compareIncome']);
