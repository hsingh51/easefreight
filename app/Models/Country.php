<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Country extends Model  {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'countries';
	protected $primaryKey = 'country_id';
	public function cities()
	{
		return $this->hasMany('App\Models\City');
	}
}