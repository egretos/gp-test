<?php

namespace Egretos\GamepointTestTask\Controllers;

use Egretos\GamepointTestTask\Models\Country;
use Egretos\GamepointTestTask\Models\Currency;
use Egretos\GamepointTestTask\Models\Transaction;
use Egretos\GamepointTestTask\Validators\ViewTransactionsRequestValidator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpFoundation\Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TransactionController
{
	/**
	 * @throws SyntaxError
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function index(Request $request): string
	{
		$queryParams = [
			'page' => $request->query->get('page', 1),
			'user_id' => $request->query->get('user_id'),
			'country_code' => $request->query->get('country_code'),
			'currency_code' => $request->query->get('currency_code'),
			'date' => $request->query->get('date'),
		];
		
		$validator = new ViewTransactionsRequestValidator();
		$errors = $validator->validate($queryParams);
		
		if (!empty($errors)) {
			return view('error.twig', ['errors' => $errors]);
		}
		
		$countries = Country::all()->toArray();
		$currencies = Currency::all()->toArray();
		
		$transactions = Transaction::query()
			->with([
				'currencyRates' => fn (HasMany $query) => $query->where('currency_to_iso', env('DEFAULT_CURRENCY')),
			])
			->filter($queryParams)
			->paginate(15, ['*'], 'page', $queryParams['page']);
		
		return view('index.twig', [
			'transactions' => $transactions->items(),
			'countries' => $countries,
			'currencies' => $currencies,
			'current_page' => $transactions->currentPage(),
			'total_pages' => ceil($transactions->total() / 15),
			'user_id' => $queryParams['user_id'],
			'country_code' => $queryParams['country_code'],
			'currency_code' => $queryParams['currency_code'],
			'date' => $queryParams['date'],
		]);
	}
}