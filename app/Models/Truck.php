<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
	use SoftDeletes;

    use HasFactory;

	protected $guarded = ['id'];

    public $appends = [
        'plates',
    ];

    public function getPlatesAttribute()
    {
        return $this->attributes['placas'];
    }

	public function getCreatedAtAttribute($value)
	{
    	return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
	}
}
