<?php

namespace App\Http\Controllers;

use App\ChangeLog;
use App\ParkingLot;
use App\User;
use Illuminate\Http\Request;
use Validator;

class ParkingLotController extends Controller
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
        $parking_lot = ParkingLot::all();
        $reqult      = array();
        foreach ($parking_lot as $item) {
            $result = [
                'id'         => $item->id,
                'longitude'  => $item->longitude,
                'latitude'   => $item->latitude,
                'creator_id' => $item->user->account,
                'quantity'   => $item->info->last()->quantity,
                'changer_id' => $item->info->last()->user->account,
            ];
        }

        return response()->json($result);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $rule = [
            'longitude'  => 'required',
            'latitude'   => 'required',
            'creator_id' => 'required',
            'quantity'   => 'required|min:0|numeric',
            'status'     => 'required|min:0|max:3',
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::find($data['creator_id']);
        if (is_null($user)) {
            return response()->json([
                'error' => 'error of creator_id : ' . $id,
            ]);
        }
        $parking_lot = ParkingLot::create([
            'longitude'  => $data['longitude'],
            'latitude'   => $data['latitude'],
            'creator_id' => $data['creator_id'],
        ]);

        $change_log = ChangeLog::create([
            'parking_lot_id' => $parking_lot->id,
            'changer_id'     => $data['creator_id'],
            'status'         => $data['status'],
            'quantity'       => $data['quantity'],
        ]);

        $result = [
            'id'         => $parking_lot->id,
            'longitude'  => $parking_lot->longitude,
            'latitude'   => $parking_lot->latitude,
            'creator_id' => $parking_lot->creator_id,
            'info'       => $change_log,
        ];

        return response()->json($result);

    }

    public function show($id)
    {
        $parking_lot = ParkingLot::find($id);
        if (is_null($parking_lot)) {
            return response()->json([
                'error' => 'error of parking_lot_id : ' . $id,
            ]);
        }
        $info   = ChangeLog::where('parking_lot_id', $parking_lot->id)->get()->last();
        $result = [
            'id'         => $parking_lot->id,
            'longitude'  => $parking_lot->longitude,
            'latitude'   => $parking_lot->latitude,
            'creator_id' => $parking_lot->creator_id,
            'info'       => $info,
        ];

        return response()->json($result);
    }
}
