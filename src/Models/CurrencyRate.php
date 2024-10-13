<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
	protected $table = 'currency_rates';
	
	protected $fillable = [
		'currency_from_iso',
		'currency_to_iso',
		'rate'
	];
}