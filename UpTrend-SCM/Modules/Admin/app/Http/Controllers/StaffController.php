<?php 

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\App\Models\Staff;
use Illuminate\Http\Request;
use Modules\Admin\App\Models\ProductionStage;
use App\Http\Controllers\Controller; 
class StaffController extends Controller
{
    public function index()
    {
        $staffMembers = Staff::all();
        return view('admin::staff.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('admin::staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:staff,email',
            'age' => 'required|integer|min:18',
            'hire_date' => 'required|date',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',
        ]);

        // Find all stages with their staff count
        $stages = ProductionStage::withCount('staff')->get();
        
        // Filter out stages that are full
        $availableStages = $stages->filter(function ($stage) {
            return is_null($stage->max_staff) || $stage->staff_count < $stage->max_staff;
        });
        // Sort by staff count (round robin)
        $stage = $availableStages->sortBy('staff_count')->first();

        // Assign the stage_id if available
        if ($stage) {
            // $validated['stage_id'] = $stage->id;
            $validated['stage_id'] = $stage ? $stage->id : 1; // fallback to stage_id 1
        }
// dd($stage, $validated);
        Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff member added successfully.');
    }

    // public function showAssignmentForm()
    // {
    //     $staffMembers = Staff::with('stage')->get();
    //     $stages = ProductionStage::all();
    //     return view('staff.assign', compact('staffMembers', 'stages'));
    // }

    public function assignStages(Request $request)
    {
        foreach ($request->assignments as $staffId => $stageId) {
            if (!empty($stageId)) {
                Staff::where('id', $staffId)->update(['stage_id' => $stageId]);
            }
        }

        return redirect()->back()->with('success', 'Assignments updated successfully!');
    }

    public function autoAssign()
    {
        $stages = ProductionStage::withCount('staff')->get();
        foreach ($stages as $stage) {
            if (isset($stage->max_staff) && $stage->staff_count > $stage->max_staff) {
                // Get surplus staff (e.g., by latest assigned)
                $surplus = $stage->staff()->latest()->take($stage->staff_count - $stage->max_staff)->get();
                foreach ($surplus as $staff) {
                    $staff->stage_id = null;
                    $staff->save();
                }
                // Update the staff_count for the stage object
                $stage->staff_count = $stage->max_staff;
            }
        }
        $unassignedStaff = Staff::whereNull('stage_id')->get();

        foreach ($unassignedStaff as $staff) {
            // Sort stages by least number of staff
            $stage = $stages
                ->filter(fn($s) => !isset($s->max_staff) || $s->staff_count < $s->max_staff)
                ->sortBy('staff_count')
                ->first();

            if ($stage) {
                $staff->stage_id = $stage->id;
                $staff->save();

                // Manually increase the count since it's cached in the loop
                $stage->staff_count++;
            }
        }

        return redirect()->back()->with('success', 'Staff automatically assigned to stages!');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin::staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:staff,email,' . $id,
            'age' => 'required|integer|min:18',
            'hire_date' => 'required|date',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'address' => 'required|string',
        ]);
        $staff->update($validated);
        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
    }
}



