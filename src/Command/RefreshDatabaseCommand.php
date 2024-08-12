<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:refresh-database',
    description: 'Drop the database schema and apply migrations',
)]
class RefreshDatabaseCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Drop the database schema and apply migrations')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Force dropping the schema without confirmation')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $force = $input->getOption('force');

        // Drop the database schema
        $io->section('Dropping database schema...');
        $dropSchemaCommand = 'php bin/console doctrine:schema:drop --full-database --force';
        if ($force) {
            $dropSchemaCommand .= ' --force';
        }
        $result = $this->runCommand($dropSchemaCommand, $io);
        if ($result !== 0) {
            $io->error('Failed to drop database schema.');
            return Command::FAILURE;
        }

        // Create the schema
        $io->section('Creating database schema...');
        $createSchemaCommand = 'php bin/console doctrine:schema:create';
        $result = $this->runCommand($createSchemaCommand, $io);
        if ($result !== 0) {
            $io->error('Failed to create database schema.');
            return Command::FAILURE;
        }

        // Apply migrations
        $io->section('Applying migrations...');
        $migrateCommand = 'php bin/console doctrine:migrations:migrate --no-interaction';
        $result = $this->runCommand($migrateCommand, $io);
        if ($result !== 0) {
            $io->error('Failed to apply migrations.');
            return Command::FAILURE;
        }

        $io->success('Database refreshed successfully!');
        return Command::SUCCESS;
    }

    private function runCommand(string $command, SymfonyStyle $io): int
    {
        $io->note(sprintf('Running command: %s', $command));
        exec($command, $outputLines, $returnVar);
        foreach ($outputLines as $line) {
            $io->note($line);
        }
        return $returnVar;
    }
}
