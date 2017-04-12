<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OceanTerminalLoadCharge extends Model
{
	protected $table = 'ocean_terminal_load_charges';
	protected $primaryKey = 'ocean_terminal_load_charge_id';

    public function oceanLocalTerminalRate()
    {
       return $this->belongsTo('App\Models\OceanLocalTerminalRate');
    }

    
}
