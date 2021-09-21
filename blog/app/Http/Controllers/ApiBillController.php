<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Book;
use App\Models\ChangePriceOfStock;
use App\Models\OutOfStock;
use App\Models\RevenueMonth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bill_list = Bill::with('User')->latest()->paginate(10);
        
        return response()->json($bill_list);
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
        $books_in_cart = $request->books_array;
        $list_item_out_of_stock = array();
        $list_item_change_price = array();

        //Check giá thay đổi hoặc số lượng không đủ
        foreach($books_in_cart as $item){
            $book = new Book();
            $book = Book::find($item['bookId']);
            
            if($book->quatity < $item['quatity']){
                $item_out_of_stock = new OutOfStock();
                $item_out_of_stock->book_id = $book->id;
                $item_out_of_stock->book_name = $book->book_name;
                $item_out_of_stock->quatity = $book->quatity;
                
                array_push($list_item_out_of_stock,$item_out_of_stock);
            }
            if($book->price != $item['unitPrice']){
                $item_change_price =new ChangePriceOfStock();
                $item_change_price->book_id = $book->id;
                $item_change_price->book_name = $book->book_name;
                $item_change_price->unit_price = $book->price;
                array_push($list_item_change_price, $item_change_price);
            }
        }
        if(!empty($list_item_out_of_stock)){
            return response()->json([$list_item_out_of_stock, 'message1'=>'hàng không đủ hoặc hết',$list_item_change_price,'message2'=>"hàng đã đổi giá"]);
        }else{
            $billdetail_array= array();
            $bill=new Bill();
            $bill->user_id=$request->user_id;
            $bill->total = $request->total;
            $bill->status = $request->status;
            $bill->save();
            foreach($books_in_cart as $item){
                $billdetail = new BillDetail();
                $billdetail->bill_id = $bill->id;
                $billdetail->book_id = $item['bookId'];
                $billdetail->book_name = $item['bookName'];
                $billdetail->quatity = $item['quatity'];
                $billdetail->unit_price = $item['unitPrice'];
                $book = Book::find($item['bookId']);
                $book->quatity = $book->quatity - $billdetail->quatity;
                $book->save();
                $billdetail->save();
                array_push($billdetail_array,$billdetail);
            }

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
            $revenue_month->sale = $revenue_month->sale + $bill->total;
            $revenue_month->total = $revenue_month->total + $bill->total;
            $revenue_month->save(); 

        }
        return response()->json([$billdetail_array,'message'=>'thanh toán thành công']);
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
        $bill = Bill::find($id);
        return $bill;
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

    public function getNumberBills(){
        $bill_number = Bill::all()->count();
        return response()->json(['bill_number'=>$bill_number]);
    }
    public function getBillByNumber($number){
        $bill_list = Bill::latest()->take($number)->paginate(5);
        return response()->json($bill_list);
    }
    
    public function getBillInDate(){
        // $bill_list = Carbon::now()->month;
        $bill_list=[];
            $days_of_month = Carbon::now()->daysInMonth;
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
            $day_array = [];
        for($i=1;$i <= $days_of_month;$i++){
            $revenue_in_day = Bill::whereDate('created_at','=',$year.'-'.$month.'-'.$i)->sum('total');
            array_push($day_array,$i);
           array_push($bill_list,$revenue_in_day);
        }
        return response()->json(['date_array'=>$day_array,'bill_in_date_of_month'=>$bill_list]);
    }

    public function getBillInMonth(){
        $bill_list = Carbon::now()->day;
        // $days_of_month = Carbon::now()->daysInMonth;
            // $bill_list = Bill::whereMonth('created_at','=',Carbon::now()->month())->get();
        return $bill_list;
    }

   public function getBillByIdUser($user_id){
       $bills = Bill::with('billdetails')->where('user_id',$user_id)->latest()->get();
       return response()->json($bills);
   }
}
