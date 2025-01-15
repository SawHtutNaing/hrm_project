<?php

use Illuminate\Support\Facades\Route;
use Modules\FieldService\Http\Controllers\AttendanceController;
use Modules\FieldService\Http\Controllers\CampaignController;
use Modules\FieldService\Http\Controllers\CampaignImportController;
use Modules\FieldService\Http\Controllers\CampaignReportController;
use Modules\FieldService\Http\Controllers\DailyAdjustmentController;
use Modules\FieldService\Http\Controllers\FieldServiceSettingController;
use Modules\FieldService\Http\Controllers\ImageGalleryController;
use Modules\FieldService\Http\Controllers\OutletController;
use Modules\FieldService\Http\Controllers\QuestionnaireController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::resource('campaign', CampaignController::class)->names('campaign');
    Route::resource('campaign/get/attendance/', AttendanceController::class)->names('attendance');
    Route::controller(CampaignController::class)->prefix('campaign/')->group(function () {
        Route::put('{campaign}/start', 'start')->name('campaign.start');
        Route::put('{campaign}/close', 'close')->name('campaign.close');
        // Route::get('list/2', [CampaignController::class, 'list2'])->name('campaign.list2');
        Route::get('spin/wheel', 'spinwheel')->name('campaign.spinwheel');
        Route::get('{campaign}/product/tx', 'ptx')->name('campaign.ptx');
        Route::get('get/product', 'getProduct')->name('campaign.getProduct');
        Route::get('questionnaire/form', 'questionnaire')->name('campaign.questionnaire');

        Route::get('{campaign_id}/recent/{location_id}/tx', 'recentTx')->name('campaign.recentTx');
        Route::get('{campaign_id}/get/{location_id}/recent/txs', 'getrecentTxs');

        Route::get('{id}/view/over-all-report', 'viewWithOverAllReport')->name('campaign.showOar');
        Route::get('{id}/view/attendance-list', 'viewWithAl')->name('campaign.showAL');
        Route::get('{id}/view/gallery', 'viewWithGrallery')->name('campaign.showGallery');
        Route::get('{id}/view/product-summary', 'viewWithProductSummary')->name('campaign.showPs');

    });
    Route::controller(FieldServiceSettingController::class)->prefix('setting/campaign')->group(function () {
        Route::get('/', 'index')->name('fieldService.name');
        Route::post('/store', 'store')->name('fieldServiceSetting.store');
    });

    Route::controller(AttendanceController::class)->group(function () {
        Route::prefix('campaign/attendance')->group(function () {
            Route::get('/get', 'getAttendance')->name('campaign.getAttendance');
            Route::get('{campaign}/check-in', 'checkInForm')->name('campaign.checkInForm');
            Route::post('{campaign}/check-in', 'checkIn')->name('campaign.checkIn');

            Route::get('{campaign}/check-out', 'checkOutForm')->name('campaign.checkOutForm');
            Route::post('{campaign}/check-out', 'checkOut')->name('campaign.checkOut');
        });
    });

    Route::get('campaign/user/data', [CampaignController::class, 'getuserSelectData']);

    Route::controller(QuestionnaireController::class)->group(function () {
        Route::prefix('questionnaire/')->group(function () {
            Route::get('/', 'index')->name('quest.index');
            Route::get('/get', 'getData');
            Route::post('/store', 'store')->name('quest.store');
            Route::get('{questionnaires}/edit', 'edit')->name('quest.edit');
            Route::post('{id}/update', 'update')->name('quest.update');
            Route::delete('/{questionnaires}/delete', 'destroy');
            Route::get('{questionnaires}/show', 'show')->name('campaign.questionnaire');
        });
    });

    Route::controller(ImageGalleryController::class)->prefix('gallery/')->group(function () {
        Route::get('/', 'index')->name('gallery.index');
        Route::post('/store', 'store')->name('gallery.store');
        Route::get('/get/{campaign_id}/data', 'data')->name('gallery.data');
        Route::get('{gallery}/edit', 'edit')->name('gallery.edit');
        Route::post('{id}/update', 'update')->name('gallery.update');
        Route::delete('{id}/delete', 'destroy')->name('gallery.destroy');
    });

    Route::controller(CampaignReportController::class)->prefix('/campaign/report/')->group(function () {
        Route::get('/index', 'index')->name('campaign.report');
        Route::get('/item', 'itemReport')->name('campaign.item.report');
        Route::get('/{id}/get', 'getTxByCampaign');
        Route::get('/get/all', 'getAllTx');
        Route::get('{campaignId}/daily/report', 'exportDailyReport')->name('campaign.report.export');
    });
    Route::controller(DailyAdjustmentController::class)->prefix('daily/adjust')->group(function () {
        Route::get('/{location_id}/{campaign_id}', 'index')->name('dailyAdjust.index');
        Route::get('/{location_id}/get/product', 'getProductStockData')->name('dailyAdjust.getProduct');
    });

    Route::controller(OutletController::class)->prefix('outlet/')->group(function () {
        Route::post('/create', 'store')->name('outlet.create');
    });

    Route::controller(CampaignImportController::class)->prefix('import/campaign')->group(function () {
        Route::get('/show', 'index')->name('campaign.ImportUi');
        Route::post('/', 'import')->name('campaign.import');
        Route::get('/template/download', 'download')->name('download.campaignExcelTemplate');
    });

});
