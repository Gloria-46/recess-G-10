<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // This line is usually present by default

// ... rest of your controller code
 use App\Models\Inventory;
use App\Models\Shipment;
use App\Models\Supplier;


class DashboardController extends Controller
{
    //
   
public function index()
{
    return view('dashboard', [
        'inventory' => Inventory::all(),
        'shipments' => Shipment::all(),
        'suppliers' => Supplier::all(),
    ]);
}

}
