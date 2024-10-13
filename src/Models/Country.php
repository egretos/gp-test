<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'countries';
	public $incrementing = false;
	
	protected $fillable = [
		'iso_code',
	];
}