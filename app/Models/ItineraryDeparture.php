<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItineraryDeparture extends Model
{
	protected $table = 'itinerary_departures';
	protected $primaryKey = 'itinerary_departure_id';

    public function itinerary()
    {
       return $this->belongsTo('App\Models\Itinerary');
    }

    
}
