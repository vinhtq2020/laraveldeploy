<?php

namespace App\Http\Controllers;

use App\Models\BookRate;
use Illuminate\Http\Request;

class ApiBookRateController extends Controller
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
     * @param  int  $book_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $book_id)
    {
        $book_rate = BookRate::where('book_id',$book_id)->first();
        if($book_rate==null){
            $book_rate = new BookRate();
            $book_rate->book_id = $book_id;
        }
        $new_vote_number = $book_rate->vote_number + 1;
        $rate_add = $request->rate_add;
        $book_rate->rate = ($book_rate->rate * $book_rate->vote_number + $rate_add)/$new_vote_number;
        $book_rate->vote_number = $new_vote_number;
        $book_rate->save();
        return response()->json($book_rate);
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

}
