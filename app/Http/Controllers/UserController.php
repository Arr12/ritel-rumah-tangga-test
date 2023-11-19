<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->isAdmin) {
            return view('pages.users');
        } else {
            return redirect()->route('/admin/dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = User::pluck('name', 'name')->all();
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
            'email' => 'required',
            'password' => 'required',
        ]);
        $data_array = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'isAdmin' => $request->input('isAdmin'),
        ];
        $data = User::create($data_array);
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
        $perPage = (int)$request->input('perPage', 5);
        $page = (int)$request->input('page', 1);
        if($request->type === 'audits') {
            $data = Audit::with('user')->where('auditable_type', 'App\Models\User')->where('event', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = Audit::with('user')->where('auditable_type', 'App\Models\User')->where('event', 'like', '%' . $request->event . '%')->count();
        } else {
            if($request->name != '') {
                $data = User::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
                $total = User::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
            } else {
                $total = User::where('remove', false)->count();
                $data = User::where('remove', false)->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
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
                'next_page' => $totalPages <= 1 ? 1 : $page + 1,
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
    public function edit(Request $request, $id)
    {
        $perPage = $request->input('perPage', 5);
        $page = $request->input('page', 1);
        if($request->type === 'search') {
            $data = User::where('name', 'like', '%' . $request->name . '%')->orderBy('created_at', 'desc')->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = User::where('remove', false)->where('name', 'like', '%' . $request->name . '%')->count();
        }
        else {
            $data = User::where('id', $id)->skip(($page - 1) * $perPage)->take($perPage)->get();
            $total = User::where('remove', false)->where('id', $id)->skip(($page - 1) * $perPage)->count();
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
            'next_page' => $totalPages <= 1 ? 1 : $page + 1,
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $data = User::findOrFail($request->id);
        if($request->input('password')) {
            $data->update([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'isAdmin' => $request->input('isAdmin')
            ]);
        } else {
            $data->update([
                'name' => $request->input('name'),
                'isAdmin' => $request->input('isAdmin')
            ]);
        }
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
        $data = User::findOrFail($id);
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
