<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\App\Models\ProductionStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Controllers\Controller;

class ProductionStageController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::orderBy('order')->get(); // Fetch all stages from the database
        return view('admin::stages.index', compact('stages')); // Pass them to a view
    }
    public function create()
    {
        return view('admin::stages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'max_staff' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request) {
            $newOrder = $request->order;

            // Shift orders of existing stages >= new order by 1
            ProductionStage::where('order', '>=', $newOrder)
                ->increment('order');

            // Create new stage with the requested order
            ProductionStage::create($request->all());
        });

        // ProductionStage::create($request->all());

        return redirect()->route('stages.index')->with('success', 'Stage created successfully.');
    }

    public function edit($id)
    {
        $stage = ProductionStage::findOrFail($id);
        return view('admin::stages.edit', compact('stage'));
    }

    public function update(Request $request, $id)
    {
        $stage = ProductionStage::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'max_staff' => 'nullable|integer',
        ]);

        try {
            $stage->update($validated);
            return redirect()->route('stages.index')->with('success', 'Stage updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['order' => 'The order value must be unique. Please choose another.']);
        }
    }

    public function destroy($id)
    {
        $stage = ProductionStage::findOrFail($id);
        DB::transaction(function () use ($stage) {
            $deletedOrder = $stage->order;
            $stage->delete();

            // Decrement order of stages that were after the deleted one
            ProductionStage::where('order', '>', $deletedOrder)
                ->decrement('order');
        });
        // $stage->delete();
        return redirect()->route('stages.index')->with('success', 'Stage deleted successfully.');
    }
}
