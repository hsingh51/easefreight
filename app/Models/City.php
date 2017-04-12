<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class City extends Model  {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cities';
	protected $primaryKey = 'city_id';
	/**
	 * One to Many relation
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function countries() 
	{
		return $this->belongsTo('App\Models\Country');
	}
	
}