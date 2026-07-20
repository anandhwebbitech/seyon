<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MilestoneSetting;
use Illuminate\Http\Request;

class MileStoneController extends Controller
{
    public function index(){
        $milestones = MilestoneSetting::get();
        return view('admin.milestone.index', compact('milestones'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'milestone.*.name'   => 'required|string|max:50',
            'milestone.*.amount' => 'required|numeric|min:0',
            'milestone.*.status' => 'nullable|boolean',
        ]);

        foreach ($request->milestone as $id => $data) {

            $milestone = MilestoneSetting::find($id);

            if ($milestone) {
                $milestone->update([
                    'name'   => $data['name'],
                    'amount' => $data['amount'],
                    'status' => isset($data['status']) ? 1 : 0,
                ]);
            }
        }

        return back()->with('success', 'Milestone settings updated successfully!');
    }
}
