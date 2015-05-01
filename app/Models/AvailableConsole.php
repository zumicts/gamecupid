<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableConsole extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'available_console';


	/**
	*
	* Relations
	*
	**/
	public function console()
	{
		return $this->hasOne('App\Models\Console', 'id', 'console_id');
	}
}
