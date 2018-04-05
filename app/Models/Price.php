<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $connection = 'foma';
	protected $table = "PRICE";
}
