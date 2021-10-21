<?php

namespace App\Console\Commands;

use App\Models\Traffic;
use App\Models\AvailableUnits;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DataBaseDebug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cofen:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar base de datos COFEN';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        foreach (Traffic::all() as $key => $value) {
            dump(
                $value->id,
                Carbon::parse($value->deadline)->gt($now)
            );

            if ( Carbon::parse($value->deadline)->lt($now) ) {
                dump(
                    'Deleted: '.
                    # $value->delete().
                    "\n"
                );
            }
        }
        dump('Cantidad de Traffico: '.AvailableUnits::count());
    }
}
