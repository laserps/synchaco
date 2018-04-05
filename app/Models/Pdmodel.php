<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdmodel extends Model
{
    protected $connection = 'foma';
	protected $table = "PDMODEL";
}
