<?php

namespace Egretos\GamepointTestTask\Console;

use Egretos\GamepointTestTask\Service\CSVImportService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPHPCommand extends Command
{
	private CSVImportService $csvImportService;
	
	public function __construct(?string $name = null)
	{
		$this->csvImportService = new CSVImportService();
		
		parent::__construct($name);
	}
	
	protected function configure(): void
	{
		$this->setName('import:csv {path}');
		$this->setDescription('Import a csv file');
		$this->addArgument('path', InputArgument::REQUIRED);
	}
	
	public function execute(InputInterface $input, OutputInterface $output): int
	{
		$path = $input->getArgument('path');
		
		try {
			$total = $this->csvImportService->importCSVFile($path);
		} catch (Exception $e) {
			$total = 0;
			$output->writeln('<error>' . $e->getMessage() . '</error>');
		}
		
		$output->writeln('<info>Success, imported '.$total.' transactions</info>');
		
		return Command::SUCCESS;
	}
}
