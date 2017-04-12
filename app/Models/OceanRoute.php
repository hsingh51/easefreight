<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OceanRoute extends Model
{
	protected $table = 'ocean_routes';
	protected $primaryKey = 'ocean_route_id';

    public function front_itinerary()
    {
    	$week = date('W', strtotime(CURRENT_DATETIME));
        return $this->hasMany('App\Models\ItineraryOfr')->where('itinerary_ofr.week','>=',$week)->take(5);
    }

}
