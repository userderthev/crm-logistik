<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Traffic;
use App\Models\AvailableUnits;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class TrafficController extends Controller
{
    public $trafficProps = [
        'provider:id,name',
        'truck:id,type,placas',
        'operator:id,name',
        'origin:id,name',
        'target:id,name',
        'availableUnits',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Trafico Habilitado: todos los registros de Traffics que existan y que SI TENGAN
        registros en AvailableUnits*/

        /*Trafico Inhabilitado: todos los registros de Traffics que existan y que NO TENGAN
        registros en AvailableUnits*/

        $disabledTraffics =
            Traffic::doesntHave('availableUnits')
            ->join('available_units as b','traffic.id','b.traffic_id')
            ->orderBy('b.deadline','desc')
            ->orderBy('b.slug')
            ->select('traffic.*','b.slug')
            ->with($this->trafficProps)
            ->get()
            ->unique('slug')
        ;

        $enabledTraffics =
            Traffic::has('availableUnits')
            ->join('available_units as b','traffic.id','b.traffic_id')
            ->orderBy('b.deadline','desc')
            ->orderBy('b.slug')
            ->where('b.deleted_at',null)
            ->select('traffic.*','b.slug','b.deadline'/**,'b.id as unit_id'*/)
            ->with($this->trafficProps)
            ->get()
        ;

        return [
            'disabledTraffics' => Arr::flatten($disabledTraffics),
            'enabledTraffics' => Arr::flatten($enabledTraffics),
        ];
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
        $newTraffic = $req->all();

        $traffic = Traffic::create($newTraffic);

        $this->addAvailableUnit($traffic->id);

        if ($traffic) {
            # $this->sendAvailableUnit($traffic);
        }

        return $traffic->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function show(Traffic $traffic)
    {
        return Traffic::find($traffic)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function edit(Traffic $traffic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Traffic $traffic)
    {
        $editTraffic = $req->all();

        if ($req->rejection_motive_id) {
            $editTraffic = $traffic::find($req->id)->toArray();
            $editTraffic['rejection_motive_id'] = $req->rejection_motive_id;
        }

        return $traffic->update($editTraffic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Traffic $traffic)
    {
        return $traffic->delete();
    }

    public function addAvailableUnit($id)
    {
        return AvailableUnits::create([
            'slug' => '#REF-'.$id,
            'deadline' => Carbon::now()->addHours(3),
            'traffic_id' => $id,
        ]);
    }

    public function sendAvailableUnit($args)
    {
        $client = new Client;

        $msg = "
            *UNIDAD DISPONIBLE*\n".
            'Tipo de Unidad: '.$args->truck->type.".\n".
            'Origen: '.$args->origin->name.".\n".
            'Destino: '.$args->target->name."."
        ;

        # $client->get(
        #    'https://api.chat-api.com/instance198420/status?token=hcaiuaxv3rwpvlwi'
        # );

        $client->request(
            'GET',
            'https://eu77.chat-api.com/instance198420/status',
            [
                'query' => ['token' => 'hcaiuaxv3rwpvlwi'],
            ],
        );

        $resp = $client->request(
            'GET',
            'https://eu77.chat-api.com/instance198420/sendMessage',
            [
                'query' => [
                    'token' => 'hcaiuaxv3rwpvlwi',
                    'chatId' => '5218117617439-1606151220@g.us',
                    'body' => $msg,
                ],
            ],
        );

        return json_decode($resp->getBody(), true);
    }
}
