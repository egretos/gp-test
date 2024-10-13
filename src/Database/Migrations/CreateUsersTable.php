<?php

namespace Egretos\GamepointTestTask\Database\Migrations;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable
{
	public function up(): void
	{
		Manager::schema()->create('users', function (Blueprint $table) {
			$table->string('id')->unique();
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Manager::schema()->dropIfExists('users');
	}
}