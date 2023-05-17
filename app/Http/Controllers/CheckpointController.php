<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function result()
    {
        $results = DB::select(
            "select t.starting_number,c0.time as start_date,c1.time as stop_date from (select starting_number FROM sss.checkpoints group by starting_number) t
            left join checkpoints c0 on t.starting_number=c0.starting_number and c0.checkpoint_number=0
            left join checkpoints c1 on t.starting_number=c1.starting_number and c1.checkpoint_number=1
            order by starting_number"
        );
        return response()->json($results);
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
