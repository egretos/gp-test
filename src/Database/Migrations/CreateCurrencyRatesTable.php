<?php

namespace Egretos\GamepointTestTask\Database\Migrations;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyRatesTable
{
	public function up(): void
	{
		Manager::schema()->create('currency_rates', function (Blueprint $table) {
			$table->string('currency_from_iso');
			$table->string('currency_to_iso');
			$table->double('rate');
			$table->timestamps();
			
			$table->unique(['currency_from_iso', 'currency_to_iso']);
			
			$table->foreign('currency_from_iso')
				->references('iso_code')
				->on('currencies')
				->onDelete('cascade');
			
			$table->foreign('currency_to_iso')
				->references('iso_code')
				->on('currencies')
				->onDelete('cascade');
		});
	}
	
	public function down(): void
	{
		Manager::schema()->dropIfExists('currency_rates');
	}
}