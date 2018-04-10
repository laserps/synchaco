<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prod extends Model
{
	protected $connection = 'foma';
	protected $table = "PROD";

	public function PRODXA(){
		return $this->hasMany('App\Models\PRODXA','FCPROD','FCSKID');
	}
	public function PRODXA_HACO(){
		return $this->hasOne('App\Models\PRODXA_HACO','FORMA_ID_SEC','FCSKID');
	}
	public function ALLPRICE(){
		return $this->hasMany('App\Models\PRICE','FCPROD','FCSKID');
	}
	public function PRIECT_Lll(){
		// $users = App\User::LASTEST('admin')->get();
		return $this->ALLPRICE()->Lll();
	}
}
