<?php

namespace Egretos\GamepointTestTask\Database\Migrations;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable
{
	public function up(): void
	{
		Manager::schema()->create('transactions', function (Blueprint $table) {
			$table->uuid()->unique();
			$table->string('user_id');
			$table->string('currency_code');
			$table->string('country_code');
			$table->bigInteger('amount');
			$table->timestamp('happened_at');
			$table->timestamps();
			
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			
			$table->foreign('currency_code')
				->references('iso_code')
				->on('currencies');
			
			$table->foreign('country_code')
				->references('iso_code')
				->on('countries');
		});
	}
	
	public function down(): void
	{
		Manager::schema()->dropIfExists('transactions');
	}
}