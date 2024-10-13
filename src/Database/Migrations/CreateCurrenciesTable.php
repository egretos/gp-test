<?php

namespace Egretos\GamepointTestTask\Database\Migrations;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable
{
	public function up(): void
	{
		Manager::schema()->create('currencies', function (Blueprint $table) {
			$table->string('iso_code')->unique();
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Manager::schema()->dropIfExists('currencies');
	}
}