<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookReceived;
use App\Models\RevenueMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiBookReceivedController extends Controller
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
        
        $book_received = new BookReceived();
        $book_received->book_id = $request->book_id;
        $book_received ->book_name = $request->book_name;
        $book_received->quatity = $request->quatity;
        $book_received->unit_price = $request->unit_price;
        $book_received->amount = $request->amount;
        $book = Book::find($request->book_id);
        $book->quatity= $book->quatity + $request->quatity;
        $book->save();
        $book_received->save();

        $revenue_month = RevenueMonth::firstOrCreate(
            [
                'month'=>Carbon::now()->month,
                'year'=>Carbon::now()->year
            ],
            [
                'month'=>Carbon::now()->month,
                'year'=>Carbon::now()->year,
                'purchase'=>0,
                'sale'=>0,
                'total'=>0,
            ]
        );
         $revenue_month->purchase = $revenue_month->purchase + $request->amount;
         $revenue_month->total = $revenue_month->total - $request->amount;
         $revenue_month->save();
        return response()->json([$book,$book_received]);
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
        //
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
