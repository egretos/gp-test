<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $table = 'currencies';
	public $incrementing = false;
	
	protected $fillable = [
		'iso_code',
	];
}