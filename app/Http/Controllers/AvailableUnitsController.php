<?php

namespace App\Http\Controllers;

use App\Models\AvailableUnits;
use App\Models\RejectionMotive;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailableUnitsController extends Controller
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
    public function store(Request $req)
    {
        $newAvailableUnits = $req->data ?? ['slug' => '#REF-'.$req->id,'traffic_id' => $req->id];

        if (isset($newAvailableUnits->id)) {
            AvailableUnits::find($newAvailableUnits->id)->delete();
        }

        $newAvailableUnits['deadline'] =
            Carbon::now()
            ->addHours(3)
            ->format('Y-m-d H:i:s')
        ;

        $availableUnit = AvailableUnits::create($newAvailableUnits);

        $availableUnit->save();

        return $availableUnit;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvailableUnits  $availableUnits
     * @return \Illuminate\Http\Response
     */
    public function show(AvailableUnits $availableUnits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvailableUnits  $availableUnits
     * @return \Illuminate\Http\Response
     */
    public function edit(AvailableUnits $availableUnits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvailableUnits  $availableUnits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AvailableUnits $availableUnits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvailableUnits  $availableUnits
     * @return \Illuminate\Http\Response
     */
    public function destroy(AvailableUnits $availableUnit)
    {
        return $availableUnit->delete();
    }

    public function rejectionMotives()
    {
        return RejectionMotive::all();
    }
}
