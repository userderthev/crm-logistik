<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Collect::all();
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
    public function store(Request $req)
    {
        $newCollect = $req->all();

        $collect = Collect::create($newCollect)->save();

        return [$collect];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\collect  $collect
     * @return \Illuminate\Http\Response
     */
    public function show(collect $collect)
    {
        return Collect::find($collect->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\collect  $collect
     * @return \Illuminate\Http\Response
     */
    public function edit(collect $collect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\collect  $collect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, collect $collect)
    {
        $editCollect = $req->all();

        return $collect->update($editCollect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\collect  $collect
     * @return \Illuminate\Http\Response
     */
    public function destroy(collect $collect)
    {
        return $collect->delete();
    }

    public function getCollects($id)
    {
        return Collect::Where('client_id',$id)->get();
    }
}
