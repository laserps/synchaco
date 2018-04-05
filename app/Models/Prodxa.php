<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodxa extends Model
{
	protected $connection = 'foma';
    protected $table = 'PRODXA';

    public function PDBRAND(){
		return $this->hasOne('App\Models\PDBRAND','FCSKID','FCPDBRAND');
	}
	public function PDMODEL(){
		return $this->hasOne('App\Models\PDMODEL','FCSKID','FCPDMODEL');
	}
	public function PDCOLOR(){
		return $this->hasOne('App\Models\PDCOLOR','FCSKID','FCPDCOLOR');
	}
}
