<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;

class CheckpointController extends Controller
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
        return response()->json(Checkpoint::all());
    }

    public function showOne($id)
    {
        return response()->json(Checkpoint::find($id));
    }

    public function create(Request $request)
    {
        $record = Checkpoint::create($request->all());

        return response()->json($record, 201);
    }

    public function update($id, Request $request)
    {
        $record = Checkpoint::findOrFail($id);
        $record->update($request->all());

        return response()->json($record, 200);
    }

    public function delete($id)
    {
        Checkpoint::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
