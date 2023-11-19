<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('files');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Files::pluck('name', 'name')->all();
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
            'category' => 'required',
            'files.*' => 'required|file|max:10240|mimes:jpeg,jpg,png,bmp,webp',
        ]);
        $currentUrl = URL::current();
        $parsedUrl = parse_url($currentUrl);
        $data = false;
        $images_url = [];
        $files = $request->file('files');
        if(count($files) > 1){
            foreach ($files as $index => $file) {
                if ($file->isValid()) {
                    $fileName = time() . $index . '.' . $file->getClientOriginalExtension();
                    $slug = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'] . '/uploads/' . $fileName;
                    array_push($images_url, $slug);
                    $files->move(public_path('uploads'), $fileName);
                }
            }
        } else {
            if ($files[0]->isValid()) {
                $fileName = time() . 'S1' . '.' . $files[0]->getClientOriginalExtension();
                $slug = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . ':' . $parsedUrl['port'] . '/uploads/' . $fileName;
                $files[0]->move(public_path('uploads'), $fileName);
                array_push($images_url, $slug);
            }
        }
        // Move the uploaded file to a designated folder
        // You can store the file path or other information in the database if needed
        $data_array = [
            'name' => $fileName,
            'slug' => $slug,
            'description' => $request->input('description'),
            'category' => $request->input('category'),
        ];
        $data = Files::create($data_array);
        if(!$data){
            return resposne()->json([
                'success' => false,
                'message' => "Invalid file."
            ]);
        }
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => 'File uploaded successfully'
            ], 'data' => $images_url,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = Files::where('remove', false)->orderBy('created_at', 'desc')->paginate(10);
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
            $data = Files::where('name', 'like', '%' . $request->name . '%')->paginate(10);
        } else {
            $data = Files::where('id', $request->id)->paginate(10);
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
            'name' => 'required',
            'rating' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        $input = $request->all();
        $data = Files::findOrFail($request->id);
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
        $data = Files::findOrFail($id);
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
