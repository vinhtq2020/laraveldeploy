<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class ApiAuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $author = Author::withCount('Book')->latest()->paginate(5);
        return response()->json($author);
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
    public function store(ApiAuthorRequest $request)
    {
        //
        $author = new Author();
        $author->fill($request->all());
        $author->save();
        return response()->json($author);
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
        $author = Author::find($id);
        return response()->json($author);
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
    public function update(ApiAuthorRequest $request, $id)
    {
        //
        $author = Author::find($id);
        $author->author_name = $request->author_name;
        $author->introduction = $request->introduction;
        $author->save();
        return response()->json($author);
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
        $author=Author::find($id);
        if($author){
        $author->delete();
        return response()->json(["message"=>"records deleted"],202);
        }else{
            return response()->json(["message"=>"author not found"],404);
        }
    }

    public function getAllAuthors(){
        $author = Author::all();
        return response()->json($author);
    }

    public function getAuthorsByNumber($number){
        $authors = Author::withCount(['Book'])->orderBy('book_count','desc')->take($number)->get();
        return response()->json($authors);

    }
}
