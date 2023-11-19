<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
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
        $data = Product::pluck('name', 'name')->all();
        if (!$data) {
            return response()->json([
                'status' => false,
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
            'name' => 'required',
            'rating' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        $currentUrl = URL::current();
        $parsedUrl = parse_url($currentUrl);
        $data_array = [
            'name' => $request->input('name'),
            'categories_id' => $request->input('categories_id'),
            'description' => $request->input('description'),
            'slug' => $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'] . '/product/' . Str::slug($request->input('name')),
            'rating' => $request->input('rating'),
            'price' => $request->input('price'),
            'thumbnail' => $request->input('thumbnail') ? json_encode($request->input('thumbnail')) : '',
            'stock' => $request->input('stock'),
        ];
        $data = Product::create($data_array);
        if(!$data){
            return resposne()->json([
                'status' => false,
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
    public function show(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        if($request->type === 'audits') {
            $data = Audit::with('user')->where('auditable_type', 'App\Models\Product')->where('event', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Audit::with('user')->where('auditable_type', 'App\Models\User')->where('event', 'like', '%' . $request->event . '%')->count();
        }
        else {
            if($request->name != '') {
                $data = Product::with('categories')->where('remove', false)->where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
                $total = Product::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
            }
            else {
                $total = Product::where('remove', false)->count();
                $data = Product::with('categories')->where('remove', false)->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            }
        }
        if(!$data){
            return resposne()->json([
                'status' => false,
                'message' => "Data Not Found"
            ]);
        }
        $totalPages = ceil($total / $perPage);
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'Get Data Successfully'
            ],
            'pagination' => [
                'has_next_page' => $page >= $totalPages ? false : true,
                'has_previous_page' => $page <= 1 ? false : true,
                'next_page' => $page + 1,
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages,
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
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        if($request->type === 'search') {
            $data = Product::with('categories')->where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Product::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
        }
        else if($request->type === 'categories') {
            $data = Product::with('categories')->where('categories_id', $request->categories_id)->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Product::where('remove', false)->where('categories_id', $request->categories_id)->count();
        }
        else {
            $data = Product::with('categories')->where('id', $request->id)->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Product::where('remove', false)->where('id', $request->id)->skip(($page - 1) * $perPage)->count();
        }
        $totalPages = ceil($total / $perPage);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Get Detail Successfully'
        ],
        'pagination' => [
            'has_next_page' => $page >= $totalPages ? false : true,
            'has_previous_page' => $page <= 1 ? false : true,
            'next_page' => $page + 1,
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
        ],
        'data' => $data], 200);
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
            'name' => 'required',
            'rating' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        $input = $request->all();
        $data = Product::findOrFail($request->id);
        $data->update($input);
        if (!$data) {
            return response()->json([
                'status' => false,
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
        $data = Product::findOrFail($id);
        $data->update($input);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Data Deleted Successfully'
        ]], 200);
    }
}
