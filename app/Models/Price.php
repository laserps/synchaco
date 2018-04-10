<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $connection = 'foma';
	protected $table = "PRICE";

	public function scopeLll($q){
		return $q->orderBy('FCPRICENO','asc');
	}

	public function PCONTRAC(){
		return $this->hasMany('App\Models\PCONTRAC','FCSKID','FCPCONTRAC');
	}

	public function PRIECT_LLL(){
		// $users = App\User::LASTEST('admin')->get();
		return $this->PCONTRAC()->LLL();
	}
}
