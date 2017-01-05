<?php

namespace App\Http\Controllers;

use App\ChangeLog;
use App\ParkingLot;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $reqults     = [
            'count' => $parking_lot->count(),
        ];
        foreach ($parking_lot as $item) {
            $result[] = [
                'id'         => $item->id,
                'longitude'  => $item->longitude,
                'latitude'   => $item->latitude,
                'creator_id' => $item->user->account,
                'quantity'   => $item->info->last()->quantity,
                'status'     => $item->info->last()->status,
                'changer_id' => $item->info->last()->user->account,
                'updated_at' => date($item->info->last()->created_at),
            ];
        }
        $reqults['result'] = $result;

        return response()->json($reqults);
        // return Response::make(json_encode($result), 200)->header('Content-Type', 'application/json');
        // return response(json_encode($result), 200)
        //     ->header('Content-Type', 'application/json');
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

    public function change(Request $request)
    {
        $data = $request->all();

        $rule = [
            'parking_lot_id' => 'required',
            'changer_id'     => 'required',
            'status'         => 'required|min:0|max:3',
            'quantity'       => 'required|min:0numeric',
        ];

        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $user = User::find($data['changer_id']);
        if (is_null($user)) {
            return response()->json([
                'error' => 'error of changer_id : ' . $data['changer_id'],
            ]);
        }
        $parking_lot = ParkingLot::find($data['parking_lot_id']);
        if (is_null($parking_lot)) {
            return response()->json([
                'error' => 'error of parking_lot_id : ' . $data['parking_lot_id'],
            ]);
        }
        $change_log = ChangeLog::create([
            'parking_lot_id' => $data['parking_lot_id'],
            'changer_id'     => $data['changer_id'],
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

    public function delete(Request $request)
    {
        $data        = $request->all();
        $parking_lot = ParkingLot::find($data['id']);
        if (is_null($parking_lot)) {
            return response()->json([
                'error' => 'Not find parking_lot',
            ]);
        }
        $parking_lot->delete();

        return response()->json([
            'success' => 'Success delete',
        ]);
    }
}
