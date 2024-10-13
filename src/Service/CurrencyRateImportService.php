<?php

namespace Egretos\GamepointTestTask\Service;

use Egretos\GamepointTestTask\Models\Currency;
use Egretos\GamepointTestTask\Models\CurrencyRate;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyRateImportService
{
	public function import(): void
	{
		$apiURL = env('CURRENCY_API_URL');
		$baseCurrency = env('DEFAULT_CURRENCY');
		
		$client = new Client();
		$url = "$apiURL/latest/$baseCurrency";
		
		try {
			$response = $client->get($url);
			
			$body = $response->getBody()->getContents();
			
			$data = json_decode($body, true);
			
			if (isset($data['error-type'])) {
				echo 'Error: ' . $data['error-type'];
				exit;
			}
			
			$currenciesToConvert = Currency::all()->pluck('iso_code');
			
			foreach ($currenciesToConvert as $currency) {
				if (isset($data['conversion_rates'][$currency])) {
					$rate = $data['conversion_rates'][$currency];
					
					CurrencyRate::query()
						->where('currency_from_iso', $currency)
						->where('currency_to_iso', env('DEFAULT_CURRENCY'))
						->firstOrCreate([
							'currency_from_iso' => $currency,
							'currency_to_iso' => env('DEFAULT_CURRENCY'),
						], [
							'currency_from_iso' => $currency,
							'currency_to_iso' => env('DEFAULT_CURRENCY'),
							'rate' => round(1 / $rate, 8),
						]);
				}
			}
			
		} catch (Exception) {
			// Log exception here
		} catch (GuzzleException) {
			// Log exception here (request)
		}
	}
}