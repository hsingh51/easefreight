<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AfrRoute extends Model
{
	protected $table = 'afr_routes';
	protected $primaryKey = 'afr_route_id';

    public function itinerary()
    {
        return $this->hasMany('App\Models\Itinerary');
    }

    public function front_itinerary()
    {
    	$week = date('W', strtotime(CURRENT_DATETIME));
        return $this->hasMany('App\Models\Itinerary')->where('itinerary.week','>=',$week)->take(5);
    }

}
