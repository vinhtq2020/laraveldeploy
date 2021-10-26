<?php

namespace App\Http\Controllers;

use App\Models\BookUserView;
use Illuminate\Http\Request;

class ApiBookUserViewController extends Controller
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
    }

    public function updateBookUserView(Request $request){
        $book_user_view=BookUserView::where('book_id',$request->book_id)->where('user_id',$request->user_id)->first();
        if($book_user_view==null){
            $book_user_view = new BookUserView();
            $book_user_view->book_id = $request->book_id;
            $book_user_view->user_id = $request->user_id;
        }
        $book_user_view->touch();
        $book_user_view->save();
        return response()->json($book_user_view);
    }
}
