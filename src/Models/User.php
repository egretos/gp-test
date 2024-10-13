<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';
	
	protected $keyType = 'string';
	protected $primaryKey = 'id';
	public $incrementing = false;
	
	protected $fillable = [
		'id'
	];
	
	protected $casts = [
		'id' => 'string',
	];
}