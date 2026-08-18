<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function unitListing(): View
    {
        return view('inventory.unit-listing');
    }

    public function sizeListing(): View
    {
        return view('inventory.size-listing');
    }

    public function goodsGroupListing(): View
    {
        return view('inventory.goods-group-listing');
    }

    public function brandListing(): View
    {
        return view('inventory.brand-listing');
    }

    public function goodsListing(): View
    {
        return view('inventory.goods-listing');
    }

    public function salesPriceGroupListing(): View
    {
        return view('inventory.sales-price-group-listing');
    }

    public function whListing(): View
    {
        return view('inventory.warehouse-listing');
    }

    public function printBarcodeForm(): View
    {
        return view('inventory.print-barcode-form');
    }

    public function stockOpnameListing(): View
    {
        return view('inventory.stock-opname-listing');
    }

    public function transferTempListing(): View
    {
        return view('inventory.transfer-temp-listing');
    }

    public function transferWhListing(): View
    {
        return view('inventory.transfer-wh-listing');
    }

    public function adjustStockListing(): View
    {
        return view('inventory.adjust-stock-listing');
    }

    public function rawMaterialListing(): View
    {
        return view('inventory.raw-material-listing');
    }

    public function finMaterialListing(): View
    {
        return view('inventory.fin-material-listing');
    }

    public function snStatusReport(): View
    {
        return view('inventory.sn-status-report');
    }
}
