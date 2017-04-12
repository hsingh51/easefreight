<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OceanLocalTerminalRate extends Model
{
	protected $table = 'ocean_local_terminal_rates';
	protected $primaryKey = 'ocean_local_terminal_rate_id';

    public function ocean_terminal_load_charges()
    {
        return $this->hasMany('App\Models\OceanTerminalLoadCharge');
    }

    public function city()
    {
        return $this->hasMany('App\Models\City');
    }

}
