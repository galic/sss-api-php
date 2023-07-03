<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $result = Checkpoint::all();

        Log::info(CheckpointController::class . ' showAll');

        return response()->json(Checkpoint::all());
    }
    public function getCheckpoints()
    {
        $query = Checkpoint::query();
        if (request()->has('cn')) {

            $cn = request()->get('cn');
            $query = $query->where('checkpoint_number', '=', $cn);
        }
        $query = $query->orderByDesc('time');
        if (request()->has('limit')) {

            $limit = request()->get('limit');
            $query = $query->take($limit);
        }

        $checkpoints = $query->get()->toArray();

        // local reverse sort time
        usort($checkpoints, function ($item1, $item2) {
            return $item1['time'] <=> $item2['time'];
        });


        Log::info(CheckpointController::class . ' getCheckpoints');

        return response()->json($checkpoints);
    }

    public function protocol()
    {
        $results = DB::select(
            "select a.name,t.starting_number,c0.time as start_date,c1.time as stop_date from (select starting_number FROM sss.checkpoints group by starting_number) t
            left join checkpoints c0 on t.starting_number=c0.starting_number and c0.checkpoint_number=0
            left join checkpoints c1 on t.starting_number=c1.starting_number and c1.checkpoint_number=1
            left join athletes a on t.starting_number=a.starting_number
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
        $this->validate($request, Checkpoint::getValidationRules());

        $checkpoint = $request->all();
        Log::info(CheckpointController::class . ' post: ' . implode(', ', $checkpoint));

        $checkpoint = $this->removeTrailingZFromTimeField($checkpoint);
        Log::info('post converted: ' . implode(', ', $checkpoint));

        $record = Checkpoint::create($checkpoint);

        return response()->json($record, 201);
    }
    private function removeTrailingZFromTimeField($checkpoint)
    {
        if (isset($checkpoint['time']) && strtoupper(substr($checkpoint['time'], -1)) == 'Z') {
            $checkpoint['time'] = substr($checkpoint['time'], 0, -1); //remove last char
        }
        return $checkpoint;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, Checkpoint::getValidationRules());

        $record = Checkpoint::findOrFail($id);
        $record->update($request->all());

        return response()->json($record, 200);
    }

    public function delete($id)
    {
        Log::info(CheckpointController::class . ' delete: ' . $id);
        Checkpoint::findOrFail($id)->delete();
        $result = [
            'id' => $id,
            'description' => 'Deleted Successfully'
        ];
        return response($result, 200);
    }
}