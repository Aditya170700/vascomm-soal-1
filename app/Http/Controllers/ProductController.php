<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private $code = 200;
    private $message = 'success';
    private $data = null;

    function index(Request $request)
    {
        $this->data = Product::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%");
        })->paginate(10);

        return $this->response($this->data, $this->code, $this->message);
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            $this->code = 422;
            $this->message = $validator->errors();
        } else {
            $this->data = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'user_id' => $request->user->id
            ]);
        }

        return $this->response($this->data, $this->code, $this->message);
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name,' . $id . ',id',
            'price' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            $this->code = 422;
            $this->message = $validator->errors();
        } else {
            $this->data = Product::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'price' => $request->price
                ]) == 1;
        }

        return $this->response($this->data, $this->code, $this->message);
    }

    function destroy($id)
    {
        $this->data = Product::where('id', $id)->delete() == 1;

        return $this->response($this->data, $this->code, $this->message);
    }
}
