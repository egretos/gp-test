<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Transaction|Builder query()
 * @method Builder filter($queryParams)
 */
class Transaction extends Model
{
	protected $table = 'transactions';
	public $incrementing = false;
	
	protected $primaryKey = 'uuid';
	
	protected $fillable = [
		'uuid',
		'user_id',
		'currency_code',
		'country_code',
		'amount',
		'happened_at',
	];
	
	protected $casts = [
		'uuid' => 'string',
		'amount' => 'float',
		'happened_at' => 'datetime',
	];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	
	public function currency(): BelongsTo
	{
		return $this->belongsTo(Currency::class, 'currency_code', 'iso_code');
	}
	
	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class, 'country_code', 'iso_code');
	}
	
	public function scopeFilter(Builder $query, array $filters): Builder
	{
		$query->orderBy('happened_at', 'desc');
		
		if ($filters['user_id']) {
			$query->whereLike('user_id', "%{$filters['user_id']}%");
		}
		if ($filters['country_code']) {
			$query->where('country_code', $filters['country_code']);
		}
		if ($filters['currency_code']) {
			$query->where('currency_code', $filters['currency_code']);
		}
		if ($filters['date']) {
			$query->whereDate('happened_at', $filters['date']);
		}
		
		return $query;
	}
}