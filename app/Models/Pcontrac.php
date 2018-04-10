<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pcontrac extends Model
{
    protected $connection = 'foma';
	protected $table = "PCONTRAC";

	public function scopeLLL($q){
		return $q->where('FCSKID',"!=","");
	}

}
