<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItineraryOfr extends Model
{
	protected $table = 'itinerary_ofr';
	protected $primaryKey = 'itinerary_id';

    
    public function oceanRoute(){
      return $this->belongsTo('App\Models\OceanRoute');
    }

    public function itineraryOfrDeparture()
    {
    	return $this->hasMany('App\Models\ItineraryOfrDeparture')->where('itinerary_ofr_departures.departure_date','>',date('Y-m-d'));;
    }

    public function fornt_itineraryDeparture()
    {
    	return $this->hasMany('App\Models\ItineraryOfrDeparture')->take(5);
    }

    public static function boot(){
        parent::boot();    
        static::deleted(function($itinerary_ofr)
            {
                $itinerary_ofr->itineraryOfrDeparture()->delete();
            }
        );
    } 
    
}
