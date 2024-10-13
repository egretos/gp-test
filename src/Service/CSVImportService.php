<?php

namespace Egretos\GamepointTestTask\Service;

use Carbon\Carbon;
use Egretos\GamepointTestTask\Models\Country;
use Egretos\GamepointTestTask\Models\Currency;
use Egretos\GamepointTestTask\Models\Transaction;
use Egretos\GamepointTestTask\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class CSVImportService
{
	/**
	 * @throws UnavailableStream
	 * @throws Exception
	 */
	public function importCSVFile(string $filePath): void
	{
		$csv = Reader::createFromPath($filePath);
		
		$csv->setHeaderOffset(0);
		
		foreach ($csv->chunkBy(1000) as $dataChunk) {
			try {
				$this->bulkStoreTransactions(collect($dataChunk));
			} catch (Exception $e) {
				// It's a test task, but usually I put logging here
			}
		}
	}
	
	public function bulkStoreTransactions(Collection $transactionsData): void
	{
		$userIds = $transactionsData->unique('UserID')->pluck('UserID');
		$currencyIds = $transactionsData->unique('Currency')->pluck('Currency');
		$countryIds = $transactionsData->unique('Country')->pluck('Country');
		
		$this->restoreMissedUsers($userIds);
		$this->restoreMissingCurrencies($currencyIds);
		$this->restoreMissingCountries($countryIds);
		
		$transactionsData = $transactionsData->map(function ($transactionData) {
			return [
				'uuid' => Str::uuid()->toString(),
				'user_id' => $transactionData['UserID'],
				'currency_code' => $transactionData['Currency'],
				'country_code' => $transactionData['Country'],
				'amount' => $transactionData['AmountInCents'],
				'happened_at' => Carbon::createFromTimestamp($transactionData['UnixTimestamp']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			];
		});
		
		Transaction::query()->insert($transactionsData->toArray());
	}
	
	public function restoreMissedUsers(Collection $userIds): void
	{
		$existingUserIds = User::query()
			->whereIn('id', $userIds)
			->get('id')
			->pluck('id');
		
		$usersDataToCreate = $userIds
			->diff($existingUserIds)
			->map(function ($userId) {
				return [
					'id' => $userId,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				];
			})
			->toArray();
		
		User::query()->insert($usersDataToCreate);
	}
	
	public function restoreMissingCurrencies(Collection $currencyIds): void
	{
		$existingCurrencyIds = Currency::query()
			->whereIn('iso_code', $currencyIds)
			->get('iso_code')
			->pluck('iso_code');
		
		$currenciesDataToCreate = $currencyIds
			->diff($existingCurrencyIds)
			->map(function ($currencyId) {
				return [
					'iso_code' => $currencyId,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				];
			})
			->toArray();
		
		Currency::query()->insert($currenciesDataToCreate);
	}
	
	public function restoreMissingCountries(Collection $countryIds): void
	{
		$existingCountryIds = Country::query()
			->whereIn('iso_code', $countryIds)
			->get('iso_code')
			->pluck('iso_code');
		
		$countriesDataToCreate = $countryIds
			->diff($existingCountryIds)
			->map(function ($countryId) {
				return [
					'iso_code' => $countryId,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
				];
			})
			->toArray();
		
		Country::query()->insert($countriesDataToCreate);
	}
}