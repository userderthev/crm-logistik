<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderStatusSeed extends Seeder
{
    /**
     * @var string
     */
    protected $model = 'provider_statuses';

    /**
     * @var array
     */
    protected $statuses = [
		'Pendiente',
		'Revision',
		'Rechazado',
		'Aprobado',
		'Inhabilitado',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->statuses as $key => $value) {

        	dump($value);

        	DB::table($this->model)->insert([
            	'name' => $value,
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
        	]);
        }
    }
}
