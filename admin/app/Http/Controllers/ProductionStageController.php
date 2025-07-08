<?php

namespace App\Http\Controllers;

use App\Models\ProductionStage;
use Illuminate\Http\Request;

class ProductionStageController extends Controller
{
    public function index()
    {
        $stages = ProductionStage::all(); // Fetch all stages from the database
        return view('stages.index', compact('stages')); // Pass them to a view
    }
    public function create()
    {
        return view('stages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'order' => 'required|integer',
            'description' => 'nullable|string',
            'max_staff' => 'nullable|integer',
        ]);

        ProductionStage::create($request->all());

        return redirect()->route('stages.index')->with('success', 'Stage created successfully.');
    }

    public function edit($id)
    {
        $stage = ProductionStage::findOrFail($id);
        return view('stages.edit', compact('stage'));
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
        $stage->update($validated);
        return redirect()->route('stages.index')->with('success', 'Stage updated successfully.');
    }

    public function destroy($id)
    {
        $stage = ProductionStage::findOrFail($id);
        $stage->delete();
        return redirect()->route('stages.index')->with('success', 'Stage deleted successfully.');
    }
}
