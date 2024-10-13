<?php

namespace Egretos\GamepointTestTask\Console;

use Egretos\GamepointTestTask\Database\Migrations\CreateCountriesTable;
use Egretos\GamepointTestTask\Database\Migrations\CreateCurrenciesTable;
use Egretos\GamepointTestTask\Database\Migrations\CreateCurrencyRatesTable;
use Egretos\GamepointTestTask\Database\Migrations\CreateTransactionsTable;
use Egretos\GamepointTestTask\Database\Migrations\CreateUsersTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
	protected function configure(): void
	{
		$this->setName('app:migrate');
		$this->setDescription('Migrate a database');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$migrations = [
			new CreateUsersTable(),
			new CreateCountriesTable(),
			new CreateCurrenciesTable(),
			new CreateCurrencyRatesTable(),
			new CreateTransactionsTable(),
		];
		
		foreach ($migrations as $migration) {
			$migration->up();
			$output->writeln("Migration executed: " . get_class($migration));
		}

		return Command::SUCCESS;
	}
}