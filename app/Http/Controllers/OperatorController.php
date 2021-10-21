<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\ProviderStatus;
use Illuminate\Http\Request;

class OperatorController extends Controller
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

        return Operator::where($filter)->get();
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
        $newOperator = $req->all();

        /* Declaracion temporal para refactorizar base de datos */
        $newOperator['created'] = date('c');
        $newOperator['line'] = 91;

        $operator = Operator::create($newOperator)->save();

        return [$operator];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function show(Operator $operator)
    {
        return Operator::find($operator->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function edit(Operator $operator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Operator $operator)
    {
        $editOperator = $req->all();

        return $operator->update($editOperator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operator $operator)
    {
        return $operator->delete();
    }

    public function getOperators($id = null)
    {
        $filter = [];

        if ($id) {
            $filter['provider_id'] = $id;
        }

        return Operator::where($filter)->get();
    }

    public function setStatusOperator(Request $req)
    {
        return Operator::find($req->id)->update(['status_id' => $req->status]);
    }
}
