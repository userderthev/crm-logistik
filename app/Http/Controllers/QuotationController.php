<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Quotation::all();
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
        $newQuotation = $req->all();

        $quotation = Quotation::create($newQuotation)->save();

        return [$quotation];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(quotation $quotation)
    {
        return Quotation::find($quotation->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, quotation $quotation)
    {
        $editQuotation = $req->all();

        return $quotation->update($editQuotation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(quotation $quotation)
    {
        return $quotation->delete();
    }

    public function getQuotations($id)
    {
        return Quotation::Where('client_id',$id)->get();
    }
}
