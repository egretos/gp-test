<?php

namespace Egretos\GamepointTestTask\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Transaction|Builder query()
 * @method Builder filter($queryParams)
 * @property Collection $currencyRates
 * @property ?int $amountInDefaultCurrency
 * @property int $amount
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
	
	public function currencyRates(): HasMany
	{
		return $this->HasMany(CurrencyRate::class, 'currency_from_iso', 'currency_code');
	}
	
	public function getAmountInDefaultCurrencyAttribute(): ?int
	{
		$currencyRate = $this
			->currencyRates
			->where('currency_to_iso', env('DEFAULT_CURRENCY'))
			->first();
		
		if (!$currencyRate) {
			return null;
		}
		
		return round($this->amount * $currencyRate->rate, 0);
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