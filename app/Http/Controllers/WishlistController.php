<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Wishlist::pluck('name', 'name')->all();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => null
        ], 'data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'qty' => 'required',
        ]);
        $data_array = [
            'product_id' => $request->input('product_id'),
            'qty' => $request->input('qty'),
        ];
        $data = Wishlist::create($data_array);
        if(!$data){
            return resposne()->json([
                'success' => false,
                'message' => "Data Not Found"
            ]);
        }
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Data Saved Successfully'
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = Wishlist::where('remove', false)->orderBy('created_at', 'desc')->paginate(10);
        if(!$data){
            return resposne()->json([
                'success' => false,
                'message' => "Data Not Found"
            ]);
        }
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Get Data Successfully'
            ],
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if($request->type === 'search') {
            $data = Wishlist::where('name', 'like', '%' . $request->name . '%')->paginate(10);
        } else {
            $data = Wishlist::where('id', $request->id)->paginate(10);
        }
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Get Detail Successfully'
        ], 'data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'buyer_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'region' => 'required',
            'postal_code' => 'required',
        ]);
        $input = $request->all();
        $data = Wishlist::findOrFail($request->id);
        $data->update($input);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Data Saved Successfully'
        ], 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $input = [
            'remove' => true
        ];
        $data = Wishlist::findOrFail($id);
        $data->update($input);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Data Deleted Successfully'
        ]], 200);
    }
}
