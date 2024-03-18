<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
