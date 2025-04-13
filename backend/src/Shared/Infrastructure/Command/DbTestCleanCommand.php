<?php
declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbTestCleanCommand extends Command
{
    protected static $defaultName = 'app:db-test:clean';
    private Connection $connection;
    private string $environment;

    public function __construct(Connection $connection, string $environment)
    {
        parent::__construct(self::$defaultName);
        $this->connection = $connection;
        $this->environment = $environment;
    }

    protected function configure(): void
    {
        $this->setDescription('Truncate all Tables into database test. You can use it only in "test".');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->environment !== 'test') {
            $output->writeln('<error>This command only can run into dev environment.</error>');
            return Command::FAILURE;
        }

        $output->writeln('<info>Starting to clean the database...</info>');

        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0');


        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

//        foreach ($tables as $table) {
//            $output->writeln("Cleaning the table: $table");
//            $this->connection->executeStatement("TRUNCATE TABLE $table");
//        }

        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1');

        $output->writeln('<info>Test Database was empty.</info>');
        return Command::SUCCESS;
    }
}
