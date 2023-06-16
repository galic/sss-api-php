<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function showAll()
    {
        $result = Group::all();

        Log::info(CheckpointController::class . ' showAll');

        return response()->json(Group::all());
    }

    public function showOne($id)
    {
        return response()->json(Group::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, Group::getValidationRules());

        $record = $request->all();
        Log::info(GroupController::class . ' post: ' . implode(', ', $record));

        $record = Group::create($record);

        return response()->json($record, 201);
    }
    // private function removeTrailingZFromTimeField($checkpoint)
    // {
    //     if (isset($checkpoint['time']) && strtoupper(substr($checkpoint['time'], -1)) == 'Z') {
    //         $checkpoint['time'] = substr($checkpoint['time'], 0, -1); //remove last char
    //     }
    //     return $checkpoint;
    // }

    public function update($id, Request $request)
    {
        $this->validate($request, Group::getValidationRules());

        $record = Group::findOrFail($id);
        $record->update($request->all());

        return response()->json($record, 200);
    }

    public function delete($id)
    {
        Log::info(GroupController::class . ' delete: ' . $id);
        Group::findOrFail($id)->delete();
        $result = [
            'id' => $id,
            'description' => 'Deleted Successfully'
        ];
        return response($result, 200);
    }
}