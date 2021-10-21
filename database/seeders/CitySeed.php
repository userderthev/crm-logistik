<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CitySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xls ='GrupoCOFEN-2009917_Ciudades.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($xls)->getActiveSheet()->toArray();

        foreach ($spreadsheet as $key => $value) {
        	if ($key) {
        		dump($value);
        		DB::table('cities')->insert([
            		'name' => $value[0],
            		'state' =>$value[1],
            		'office' => $value[2],
        		]);
        	}
        }
    }
}
