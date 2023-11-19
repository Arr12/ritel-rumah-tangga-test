<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('pages.categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Categories::pluck('name', 'name')->all();
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
            'name' => 'required',
        ]);
        $currentUrl = URL::current();
        $parsedUrl = parse_url($currentUrl);
        $data_array = [
            'name' => $request->input('name'),
            'thumbnail' => $request->input('thumbnail') ? json_encode($request->input('thumbnail')) : '',
        ];
        $data = Categories::create($data_array);
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
    public function show(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        if($request->type === 'audits') {
            $data = Audit::with('user')->where('auditable_type', 'App\Models\Product')->where('event', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Audit::with('user')->where('auditable_type', 'App\Models\User')->where('event', 'like', '%' . $request->event . '%')->count();
        } else {
            if($request->name != '') {
                $data = Categories::with('products')->where('remove', false)->where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
                $total = Categories::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
            }
            else {
                $total = Categories::where('remove', false)->count();
                $data = Categories::with('products')->where('remove', false)->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            }
        }
        if(!$data){
            return resposne()->json([
                'status' => false,
                'message' => "Data Not Found"
            ]);
        }
        $totalPages = ceil($total / $perPage);
        if(!$data){
            return resposne()->json([
                'success' => false,
                'message' => "Data Not Found"
            ]);
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
            $data = Categories::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Categories::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
        }
        else if($request->type === 'categories') {
            $data = Categories::where('remove', false)->where('categories_id', $request->categories_id)->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Categories::where('remove', false)->where('categories_id', $request->categories_id)->count();
        }
        else if($request->type === 'print') {
            $data = Categories::where('remove', false)->where('categories_id', $request->categories_id)->orderBy('created_at', 'desc')->get();
            $total = Categories::where('remove', false)->where('categories_id', $request->categories_id)->count();
        }
        else {
            $data = Categories::where('remove', false)->where('id', $request->id)->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Categories::where('remove', false)->where('id', $request->id)->skip(($page - 1) * $perPage)->count();
        }
        $totalPages = ceil($total / $perPage);
        if (!$data) {
            return response()->json([
                'success' => false,
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
        ]);
        $input = $request->all();
        $data = Categories::findOrFail($request->id);
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
        $data = Categories::findOrFail($id);
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
