<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $code = 200;
    private $message = 'success';
    private $data = null;

    function profile(Request $request)
    {
        $this->data = $request->user;

        return $this->response($this->data, $this->code, $this->message);
    }

    function index(Request $request)
    {
        $this->data = User::when($request->search, function ($query) use ($request) {
            $params = "%{$request->search}%";

            $query->where('name', 'like', $params)
                ->orWhere('email', 'like', $params);
        })->paginate(10);

        return $this->response($this->data, $this->code, $this->message);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:' . User::ADMIN . ',' . User::USER,
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $this->code = 422;
            $this->message = $validator->errors();
        } else {
            $this->data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);
        }

        return $this->response($this->data, $this->code, $this->message);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'role' => 'required|in:' . User::ADMIN . ',' . User::USER,
            'password' => 'nullable'
        ]);

        if ($validator->fails()) {
            $this->code = 422;
            $this->message = $validator->errors();
        } else {
            $dataUpdated = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role
            ];

            if ($request->password) {
                $dataUpdated['password'] = Hash::make($request->password);
            }

            $this->data = User::where('id', $id)
                ->update($dataUpdated) == 1;
        }

        return $this->response($this->data, $this->code, $this->message);
    }

    function destroy($id)
    {
        $this->data = User::where('id', $id)->delete() == 1;

        return $this->response($this->data, $this->code, $this->message);
    }
}
