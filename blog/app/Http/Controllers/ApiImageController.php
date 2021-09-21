<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ApiImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->hasFile('file')) {
            $message = "có file";
            $file = $request->file('file');
            
            // đừng dùng hàm store,storage::url() ngu học toàn lưu thêm tên public// storage/tên hình ngu học
            $path = $file->move('images', md5($file->getClientOriginalName()).".jpg");
            $image = new Image();
            $image->url = $path;
            $image->priority = 1;
            $image->book_id = $request->book_id;
            $image->save();
        } else {
            $message = 'không có file';
            return response()->json(['message' => $message], 400);
        }
        return response()->json(['message' => $message, $image]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        if ($request->hasFile('file')) {

            // đừng dùng ->get() vì nó éo ra đâu chỉ có lỗi thôi
            $image = Image::where('book_id', $id)->first();
            $image_path = $image->url;
            if (File::exists($image_path)) {
                File::delete($image_path);
            };;
            $message = "có file";
            $file = $request->file('file');

            // đừng dùng hàm store,storage::url() ngu học toàn lưu thêm tên public || storage/tên hình ngu học
            $path = $file->move('images', md5($file->getClientOriginalName())+"_"+strtotime("now"));
            $image->url = $path;
            $image->save();
        } else {
            $message = 'không có file';
            return response()->json(['message' => $message], 400);
        }
        return response()->json(['message' => $message, $file]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $image = Image::where('book_id', $id)->first();
        if ($image) {
            $image_path = $image->url;
            if (File::exists($image_path)) {
                File::delete($image_path);
            };
            $image->delete();
            return response()->json(["message" => "records deleted"], 202);
        } else {
            return response()->json(["message" => "Image not found"], 404);
        }
        
    }
}
