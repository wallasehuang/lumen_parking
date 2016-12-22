<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
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
        return User::all();
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $rule = [
            'account'  => 'required|unique:users,account',
            'name'     => 'required',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($data, $rule);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = User::create([
            'account'  => $data['account'],
            'name'     => $data['name'],
            'password' => $data['password'],
        ]);

        return $user;

    }

    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'error' => 'error of id : ' . $id,
            ]);
        }
        return $user;
    }
}
