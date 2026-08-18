<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Modul Persediaan (Inventory)
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/units', [InventoryController::class, 'unitListing'])->name('units');
        Route::get('/sizes', [InventoryController::class, 'sizeListing'])->name('sizes');
        Route::get('/goods-groups', [InventoryController::class, 'goodsGroupListing'])->name('goods-groups');
        Route::get('/brands', [InventoryController::class, 'brandListing'])->name('brands');
        Route::get('/goods', [InventoryController::class, 'goodsListing'])->name('goods');
        Route::get('/sales-price-groups', [InventoryController::class, 'salesPriceGroupListing'])->name('sales-price-groups');
        Route::get('/warehouses', [InventoryController::class, 'whListing'])->name('warehouses');
        Route::get('/print-barcode', [InventoryController::class, 'printBarcodeForm'])->name('print-barcode');
        Route::get('/stock-opnames', [InventoryController::class, 'stockOpnameListing'])->name('stock-opnames');
        Route::get('/transfers-temp', [InventoryController::class, 'transferTempListing'])->name('transfers-temp');
        Route::get('/transfers-wh', [InventoryController::class, 'transferWhListing'])->name('transfers-wh');
        Route::get('/adjust-stocks', [InventoryController::class, 'adjustStockListing'])->name('adjust-stocks');
        Route::get('/assembly/raw-materials', [InventoryController::class, 'rawMaterialListing'])->name('assembly.raw-materials');
        Route::get('/assembly/fin-materials', [InventoryController::class, 'finMaterialListing'])->name('assembly.fin-materials');
        Route::get('/sn-status', [InventoryController::class, 'snStatusReport'])->name('sn-status');
    });
});

require __DIR__.'/auth.php';
