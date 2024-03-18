<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $code = 200;
    private $message = 'success';
    private $data = null;

    function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $this->code = 422;
            $this->message = $validator->errors();
        } else {
            $user = User::where('email', $request->email)->first();

            if (Hash::check($request->password, $user->password)) {
                $this->data = [
                    'api_token' => Str::random(255),
                ];

                $user->update($this->data);
            } else {
                $this->code = 401;
                $this->message = 'Credential doesn\'t match';
            }
        }

        return $this->response($this->data, $this->code, $this->message);
    }
}
