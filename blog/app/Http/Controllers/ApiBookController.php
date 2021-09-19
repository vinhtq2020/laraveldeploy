<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\Helper;

class ApiBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = Book::with('Category', 'Image')->latest()->paginate(5);
        return response()->json($books);
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
        $book = new Book();
        $book->book_name = $request->book_name;
        $book->book_seo = create_slug($request->book_name);
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;
        $book->content = $request->content;
        $book->nxb_id = $request->nxb_id;
        $book->republic = $request->republic;
        $book->year = $request->year;
        $book->price = $request->price;
        $book->save();
        return response()->json($book);
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
        $book = Book::with('Category', 'Image', 'Author', 'Nxb')->find($id);
        return response()->json($book);
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
        $book = Book::find($id);
        $book->book_name = $request->book_name;
        $book->category_id = $request->category_id;
        $book->author_id = $request->author_id;
        $book->content = $request->content;
        $book->nxb_id = $request->nxb_id;
        $book->republic = $request->republic;
        $book->year = $request->year;
        $book->price = $request->price;
        $book->save();
        return $book;
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
        $book = Book::find($id);
        if($book){
                
            return response()->json(["message"=>"records deleted"],202);
        }else{
            return response()->json(["message"=>"Category not found"],404);
        }
        
    }

    public function getNewBooks($number)
    {
        $books = Book::with('Category', 'Image')->latest()->take($number)->get();
        return response()->json($books);
    }

    public function getBookByCategoryId($idCategory, $number)
    {
        $book = Book::with('Image')->where('category_id', $idCategory)->take($number)->get();
        return response()->json($book);
    }

    public function getBookBestSale($number)
    {
        $start = new Carbon('first day of this month');
        $start->startOfMonth();
        $end = new Carbon('last day of this month');
        $end->endOfMonth();
        $book = Book::withCount(['bill_detail' => function (Builder $query) use($start,$end) {
            $query->whereBetween('bill_details.created_at',[$start,$end]);
        }])->with(['Image'])->orderBy('bill_detail_count','desc')->take($number)->get();
         
        return response()->json($book);
    }

    public function getBooksByAllCategories($number)
    {
        $category_array = Category::all();
        $book_by_category = [];
        foreach ($category_array as $item) {
            $books_tmp = Book::with('Image')->where('category_id', $item['id'])->take($number)->get();
            array_push($book_by_category, ['category' => $item, 'books' => $books_tmp]);
        }
        return response()->json($book_by_category);
    }

    public function getBookToSearch(Request $request)
    {
        $query = Book::with('Image');
        $query->when($request->has('min'), function ($q) {
            return $q->where('price', '>=', request('min'));
        });
        $query->when($request->has('max'), function ($q) {
            return $q->where('price', '<=', request('max'));
        });
        $query->when($request->has('author_ids'), function ($q) {
            return $q->whereIn('author_id', request('author_ids'));
        });
        $query->when($request->has('category_id'), function ($q) {
            return $q->where('category_id', request('category_id'));
        });
        $query->when($request->has('nxb_ids'), function ($q) {
            return $q->whereIn('nxb_id', request('nxb_ids'));
        });
        $query->when($request->has('book_name'), function ($q) {
            return $q->where('book_name', 'like', '%' . request('book_name') . '%');
        });

        $books = $query->latest()->paginate(12);

        return response()->json(['bookData' => $books]);
    }
}
