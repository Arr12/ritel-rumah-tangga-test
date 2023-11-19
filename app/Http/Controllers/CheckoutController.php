<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Checkout::pluck('name', 'name')->all();
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
            'invoice' => 'required',
            'payment_methods' => 'required',
            'promo_code' => 'required',
            'comment' => 'required',
            'shipping_address_id' => 'required',
            'billing_address_id' => 'required',
            'shipping' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'total' => 'required',
        ]);
        $currentUrl = URL::current();
        $parsedUrl = parse_url($currentUrl);
        $data_array = [
            'invoice' => $request->input('invoice'),
            'payment_methods' => $request->input('payment_methods'),
            'promo_code' => $request->input('promo_code'),
            'comment' => $request->input('comment'),
            'shipping_address_id' => $request->input('shipping_address_idinvoice'),
            'billing_address_id' => $request->input('billing_address_id'),
            'shipping' => $request->input('shipping'),
            'tax' => $request->input('tax'),
            'discount' => $request->input('discount'),
            'total' => $request->input('total'),
        ];
        $data = Checkout::create($data_array);
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
        $data = Checkout::where('remove', false)->orderBy('created_at', 'desc')->paginate(10);
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
            $data = Checkout::where('name', 'like', '%' . $request->name . '%')->paginate(10);
        } else {
            $data = Checkout::where('id', $request->id)->paginate(10);
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
            'invoice' => 'required',
            'payment_methods' => 'required',
            'promo_code' => 'required',
            'comment' => 'required',
            'shipping_address_id' => 'required',
            'billing_address_id' => 'required',
            'shipping' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'total' => 'required',
        ]);
        $input = $request->all();
        $data = Checkout::findOrFail($request->id);
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
        $data = Checkout::findOrFail($id);
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
