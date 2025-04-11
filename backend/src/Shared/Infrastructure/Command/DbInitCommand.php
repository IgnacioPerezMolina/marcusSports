<?php

declare(strict_types=1);

namespace MarcusSports\Shared\Infrastructure\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class DbInitCommand extends Command
{
    protected static $defaultName = 'app:db:init';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct(self::$defaultName);
        $this->connection = $connection;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Execute SQL.')
            ->addOption('test', null, InputOption::VALUE_NONE, 'Use this parameter to start test Database.');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $success = $this->initializeDatabase($this->connection, $output, 'marcusSports');

        if ($input->getOption('test')) {
            $params = $this->connection->getParams();
            $params['dbname'] = 'marcusSportsTest';
            try {
                $testConnection = DriverManager::getConnection($params);
            } catch (\Exception $e) {
                $output->writeln("<error>Error creating the conexion marcusSportsTest: {$e->getMessage()}</error>");
                return Command::FAILURE;
            }
            $success = $this->initializeDatabase($testConnection, $output, 'marcusSportsTest') && $success;
        }

        return $success ? Command::SUCCESS : Command::FAILURE;
    }

    private function initializeDatabase(Connection $connection, OutputInterface $output, string $dbName): bool
    {
        $output->writeln("<info>Inizializating '{$dbName}'...</info>");

        $sqlDirPath = __DIR__ . '/../../../../etc/databases';

        if (!is_dir($sqlDirPath)) {
            $output->writeln("<error>Folder not found: $sqlDirPath</error>");
            return false;
        }

        $finder = new Finder();
        $finder->files()
            ->in($sqlDirPath)
            ->name('*.sql')
            ->sortByName();

        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $filename = $file->getRelativePathname();
            $output->writeln("<comment>Executing {$filename} in {$dbName}</comment>");
            $sqlContent = $file->getContents();

            $queries = array_filter(array_map('trim', explode(';', $sqlContent)));

            foreach ($queries as $query) {
                if (!empty($query)) {
                    try {
                        $connection->executeStatement($query);
                    } catch (\Exception $e) {
                        $output->writeln("<error>Error inside {$filename} in database {$dbName}: {$e->getMessage()}</error>");
                        return false;
                    }
                }
            }
        }

        $output->writeln("<info>Inizalitation of '{$dbName}' completed.</info>");
        return true;
    }
}
