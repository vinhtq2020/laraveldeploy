<?php

namespace App\Http\Controllers;

use App\Models\Nxb;
use Illuminate\Http\Request;

class ApiNxbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nxbs = Nxb::withCount(['Book'])->latest()->paginate(10);
        return response()->json($nxbs);
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
        $Nxb = new Nxb();
        $Nxb->fill($request->all());
        $Nxb->save();
        return response()->json($Nxb);
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
        $nxb = Nxb::find($id);
        return response()->json($nxb);
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
        $nxb = Nxb::find($id);
        $nxb->nxb_name = $request->nxb_name;
        $nxb->save();
        return response()->json($nxb);
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
        $nxb=Nxb::find($id);
        if($nxb){
        $nxb->delete();
        return response()->json(["message"=>"records deleted"],202);
        }else{
            return response()->json(["message"=>"Category not found"],404);
        }
    }

    public function getNxbs(){
        $nsb_array = Nxb::all();
        return response()->json($nsb_array);
    }
}
