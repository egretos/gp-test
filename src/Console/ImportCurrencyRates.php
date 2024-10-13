<?php

namespace Egretos\GamepointTestTask\Console;

use Egretos\GamepointTestTask\Service\CurrencyRateImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCurrencyRates extends Command
{
	private CurrencyRateImportService $service;
	
	public function __construct(?string $name = null)
	{
		$this->service = new CurrencyRateImportService();
		parent::__construct($name);
	}
	
	protected function configure(): void
	{
		$this->setName('import:currency-rates');
		$this->setDescription('Migrate a database');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$this->service->import();
		
		return Command::SUCCESS;
	}
}