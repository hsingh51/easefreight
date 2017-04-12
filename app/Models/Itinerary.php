<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
	protected $table = 'itinerary';
	protected $primaryKey = 'itinerary_id';

    public function afrRoute()
    {
       return $this->belongsTo('App\Models\AfrRoute');
    }

    public function itineraryDeparture()
    {
    	return $this->hasMany('App\Models\ItineraryDeparture')->where('itinerary_departures.departure_date','>',date('Y-m-d'));
    }

    public function fornt_itineraryDeparture()
    {
    	return $this->hasMany('App\Models\ItineraryDeparture')->take(5);
    }
    
}
