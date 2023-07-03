<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AthleteController extends Controller
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
        //$result = Athlete::all();
        $result = Athlete::with('group')->get();
        //var_dump($result);
        //exit;
        Log::info(CheckpointController::class . ' showAll');

        return response()->json($result);
    }

    public function showOne($id)
    {
        return response()->json(Athlete::find($id));
    }

    public function create(Request $request)
    {
        $this->validate($request, Athlete::getValidationRules());

        $record = $request->all();
        Log::info(AthleteController::class . ' post: ' . implode(', ', $record));

        $record = Athlete::create($record);

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
        $this->validate($request, Athlete::getValidationRules());

        $record = Athlete::findOrFail($id);
        $record->update($request->all());

        return response()->json($record, 200);
    }

    public function delete($id)
    {
        Log::info(AthleteController::class . ' delete: ' . $id);
        Athlete::findOrFail($id)->delete();
        $result = [
            'id' => $id,
            'description' => 'Deleted Successfully'
        ];
        return response($result, 200);
    }
}