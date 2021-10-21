<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Traffic extends Model
{
	use SoftDeletes;

    use HasFactory;

	protected $guarded = ['id'];

    /**
     * Get the line record associated with the user.
     */
    public function provider()
    {
        return $this->belongsTo('App\Models\Provider');
    }

    /**
     * Get the truck record associated with the user.
     */
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck');
    }

    /**
     * Get the operator record associated with the user.
     */
    public function operator()
    {
        return $this->belongsTo('App\Models\Operator');
    }

    /**
     * Get the origin record associated with the user.
     */
    public function origin()
    {
        return $this->belongsTo('App\Models\City','origin_city');
    }

    /**
     * Get the target record associated with the user.
     */
    public function target()
    {
        return $this->belongsTo('App\Models\City','target_city');
    }

    /**
     * Get the available units record associated with the user.
     */
    public function availableUnits()
    {
        return $this->hasOne('App\Models\AvailableUnits')->latest();
    }

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value)->timezone('America/Monterrey');
        return $date->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value)->timezone('America/Monterrey');
        return $date->format('Y-m-d H:i:s');
    }

    public function delete()
    {
        // delete all related availableUnits
        $this->availableUnits()->delete();

        // it's an uglier alternative, but faster
        // AvailableUnits::where("traffic_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}
