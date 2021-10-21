<?php

namespace App\Http\Controllers;

use App\Models\Towing;
use App\Models\ProviderStatus;
use Illuminate\Http\Request;

class TowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = null, $line = null)
    {
        $filter = [];

        if ($status) {
            $filter['status_id'] = $status;
        }

        if ($line) {
            $filter['provider_id'] = $line;
        }

        return Towing::where($filter)->get();
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
        $newTowing = $req->all();

        $towing = Towing::create($newTowing)->save();

        return [$towing];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Towing  $towing
     * @return \Illuminate\Http\Response
     */
    public function show(Towing $towing)
    {
        return Towing::find($towing->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Towing  $towing
     * @return \Illuminate\Http\Response
     */
    public function edit(Towing $towing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Towing  $towing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Towing $towing)
    {
        $editTowing = $req->all();

        return $towing->update($editTowing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Towing  $towing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Towing $towing)
    {
        return $towing->delete();
    }

    public function getTowings($id = null)
    {
        $filter = [];

        if ($id) {
            $filter['provider_id'] = $id;
        }

        return Towing::where($filter)->get();
    }

    public function setStatusTowing(Request $req)
    {
        return Towing::find($req->id)->update(['status_id' => $req->status]);
    }
}
