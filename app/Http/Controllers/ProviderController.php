<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Provider;
use App\Models\ProviderStatus;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProviderController extends Controller
{
    protected $pending;

    public function __construct()
    {
        $this->pending = ProviderStatus::first()->id;

        # parent::__construct();
        # Don't forget this, you'll never know what's being done in the constructor of the parent class you extended
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Provider::all();
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
        $newProvider = $req->all();

        $provider = Provider::create($newProvider)->save();

        return [$provider];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        return Provider::find($provider->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Provider $provider)
    {
        $editProvider = $req->all();

        # $this->sendNewTruck($provider);

        return $provider->update($editProvider);
    }

    public function sendNewTruck($provider)
    {
        $client = new Client;

        $msg = "
            *LINEA CREADA*\n".
            # 'Tipo de Unidad: '.$args->truck->type.".\n".
            # 'Origen: '.$args->origin->name.".\n".
            # 'Destino: '.$args->target->name."."
            'Nombre: '.$provider->name.".\n"
        ;

        $response = $client->post('https://api.gupshup.io/sm/api/v1/msg', [
        # $response = $client->get('https://api.callmebot.com/whatsapp.php', [
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

        // You need to parse the response body
        // This will parse it into an array
        $response = json_decode($response->getBody(), true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        return $provider->delete();
    }

    public function getProviders($status=null)
    {
        if (!$status) {
            $status = ProviderStatus::where('name','Revision')->first()->id;
        }

        return Provider::where('status_id', $status)->get();
    }

    public function cities()
    {
        return City::all();
    }

    public function setStatusLine(Request $req)
    {
        return Provider::find($req->id)->update(['status_id' => $req->status]);
    }
}
