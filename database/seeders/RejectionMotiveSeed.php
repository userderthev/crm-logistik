<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RejectionMotiveSeed extends Seeder
{
    /**
     * @var string
     */
    protected $model = 'rejection_motives';

    /**
     * @var array
     */
    protected $causeRejetions = [
		'No hubo viajes para la ruta que quería el proveedor',
		'No cumplió con los requisitos de carga',
		'No se llegó acuerdo con logística',
		'Tarifa alta',
		'Se deben finiquitos',
		'Tiempo  de carga ',
		'Proveedor consiguió carga',
		'Indefinido',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # DB::table($this->model)->truncate();

        foreach ($this->causeRejetions as $key => $value) {

        	dump($value);

        	DB::table($this->model)->insert([
            	'description' => $value,
				'created_at' => new \DateTime,
				'updated_at' => new \DateTime,
        	]);
        }
    }
}
