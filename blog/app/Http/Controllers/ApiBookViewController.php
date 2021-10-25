<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookView;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiBookViewController extends Controller
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
    public function update($book_id)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $book_view = BookView::where('month',$month)->where('year',$year)->where('book_id',$book_id)->first();
        if($book_view==null){
            $book_view = new BookView();
            $book_view->book_id=$book_id;
            $book_view->month = $month;
            $book_view->year = $year;
            $book_view->view_number =0;
        }
        $book_view->view_number = $book_view->view_number +1;
        $book_view->save();
        return response()->json($book_view);
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

    public function getTopBookViewInMonth($number,$month,$year){
        $book_views = BookView::where('month',$month)->where('year',$year)->orderBy('view_number','desc')->take($number)->get();
        return response()->json($book_views);
    }

    public function getBookViewById($book_id){
        $book_views = BookView::where('book_id',$book_id)->get();
        $total=0;
        foreach($book_views as $item){
            $total +=$item;
        }
        return response()->json($total);
    }
}
