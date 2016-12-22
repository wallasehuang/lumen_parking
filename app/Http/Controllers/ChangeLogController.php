<?php

namespace App\Http\Controllers;

use App\ChangeLog;

class ChangeLogController extends Controller
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

    public function index()
    {
        return ChangeLog::all();
    }

    public function findByChanger($id)
    {
        $change_log = ChangeLog::where('changer_id', $id)->get();
        if (is_null($change_log)) {
            return response()->json([
                'error' => 'error of changer_id : ' . $id,
            ]);
        }
        return $change_log;

    }

    public function findByParking($id)
    {
        $change_log = ChangeLog::where('parking_lot_id', $id)->get();
        if (is_null($change_log)) {
            return response()->json([
                'error' => 'error of parking_lot_id : ' . $id,
            ]);
        }
        return $change_log;
    }
}
