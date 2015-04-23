<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
		$now  = date('Y-m-d h:i:s');
		$user = new User;

		$user->first_name = "John";
		$user->last_name  = "Doe";
		$user->email      = "john@doe.com";
		$user->password   = Hash::make('test1234');
		$user->banned     = false;
		$user->is_private = false;
		$user->dob        = date('Y-m-d', strtotime($now));
		$user->created_at = $now;
		$user->updated_at = $now;

		$user->save();
    }

}