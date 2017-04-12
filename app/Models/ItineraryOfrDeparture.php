<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItineraryOfrDeparture extends Model
{
	protected $table = 'itinerary_ofr_departures';
	protected $primaryKey = 'itinerary_ofr_departure_id';

    public function itinerary_ofr()
    {
       return $this->belongsTo('App\Models\ItineraryOfr');
    }

    
}
