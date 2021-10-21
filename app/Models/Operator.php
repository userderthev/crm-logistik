<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
	use SoftDeletes;

    use HasFactory;

	protected $guarded = ['id'];

    /**
     * Get the origin record associated with the user.
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
