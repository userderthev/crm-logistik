<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\ProviderStatus;
use Illuminate\Http\Request;

class TruckController extends Controller
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

        return Truck::where($filter)->get();
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
        $newTruck = $req->all();

        $truck = Truck::create($newTruck)->save();

        # $truck = Truck::updateOrCreate([ 'provider_id' => $req->provider_id ],$newTruck);

        return [$truck];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        return Truck::find($truck->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Truck $truck)
    {
        $editTruck = $req->all();

        return $truck->update($editTruck);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        return $truck->delete();
    }

    public function getTrucks($id = null)
    {
        $filter = [];

        if ($id) {
            $filter['provider_id'] = $id;
        }

        return Truck::where($filter)->get();
    }

    public function setStatusTruck(Request $req)
    {
        return Truck::find($req->id)->update(['status_id' => $req->status]);
    }

    private function sendWhatsApp($data = null)
    {
        $msg = '
            UNIDAD DISPONIBLE.'.
            ' Tipo de Unidad: '.$data->type.
            '. Origen: '.$data->origin.
            '. Destino'.$data->target
        ;

        $client = new Client;

        $resp = $client->post('https://api.gupshup.io/sm/api/v1/msg', [
        # $resp = $client->get('https://api.callmebot.com/whatsapp.php', [
            'headers' => [
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => '4a12cea09fd54653c62b1f702d777fab',
            ],
            'form_params' => [
                'channel' => 'whatsapp',
                'source' => 917834811114,
                'destination' => 5218127315097,
                # 'message' => json_encode($editProvider),
                'message' => $msg,
            ],
            // 'form_params' => [
            //     'phone' => '5218117617439',
            //     'text' => 'test',
            //     'apikey' => '204263',
            // ],
        ]);
    }
}
