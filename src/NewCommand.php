<?php

declare(strict_types=1);

namespace Reyhan\Installer\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\note;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\select;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

final class NewCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('new')
            ->setDescription('Create a new Reyhan Commerce headless application')
            ->addArgument('name', InputArgument::OPTIONAL, 'The name of the application')
            ->addOption('pgsql', null, InputOption::VALUE_NONE, 'Configure PostgreSQL as database')
            ->addOption('mysql', null, InputOption::VALUE_NONE, 'Configure MySQL as database')
            ->addOption('sqlite', null, InputOption::VALUE_NONE, 'Configure SQLite as database')
            ->addOption('seed', null, InputOption::VALUE_NONE, 'Automatically run migrations and seed sample demo catalog')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Overwrite existing directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        intro('🌿 Reyhan Commerce — Modern Headless E-Commerce Framework');

        /** @var string|null $name */
        $name = $input->getArgument('name');

        if (! $name) {
            $name = text(
                label: 'What is the name of your store project?',
                placeholder: 'my-store',
                default: 'my-store',
                required: true
            );
        }

        $targetDir = getcwd().DIRECTORY_SEPARATOR.$name;

        if (is_dir($targetDir) && ! $input->getOption('force')) {
            error("Directory [{$name}] already exists! Use --force to overwrite.");
            return Command::FAILURE;
        }

        // Database engine selection
        $dbDriver = 'pgsql';
        if ($input->getOption('mysql')) {
            $dbDriver = 'mysql';
        } elseif ($input->getOption('sqlite')) {
            $dbDriver = 'sqlite';
        } elseif (! $input->getOption('pgsql')) {
            $dbDriver = select(
                label: 'Select primary database engine:',
                options: [
                    'pgsql' => 'PostgreSQL 17+ (Recommended: Native JSONB matrices & pg_trgm)',
                    'mysql' => 'MySQL 8.0+ / MariaDB',
                    'sqlite' => 'SQLite (Local development & testing)',
                ],
                default: 'pgsql'
            );
        }

        // Seeding confirmation
        $shouldSeed = $input->getOption('seed');
        if (! $shouldSeed && ! $input->getOption('no-interaction')) {
            $shouldSeed = confirm(
                label: 'Seed initial Iranian commerce catalog (provinces, categories, sample products)?',
                default: true
            );
        }

        // 1. Scaffold files from template
        spin(
            callback: function () use ($targetDir): void {
                $this->copyTemplateDirectory(__DIR__.'/../template', $targetDir);
            },
            message: 'Scaffolding Reyhan headless project...'
        );

        // 2. Prepare .env configuration
        $this->configureEnvironment($targetDir, $name, $dbDriver);

        // 3. Install composer dependencies
        if (file_exists($targetDir.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'composer.json')) {
            $backendDir = $targetDir.DIRECTORY_SEPARATOR.'backend';
        } else {
            $backendDir = $targetDir;
        }

        spin(
            callback: function () use ($backendDir): void {
                $process = new Process(['composer', 'install', '--quiet', '--no-interaction'], $backendDir);
                $process->setTimeout(300);
                $process->run();
            },
            message: 'Installing Composer dependencies...'
        );

        // 4. Generate app key
        $keyProcess = new Process(['php', 'artisan', 'key:generate', '--force'], $backendDir);
        $keyProcess->run();

        // 5. Run migrations & seeders if requested
        if ($shouldSeed) {
            if ($dbDriver === 'sqlite') {
                $dbFile = $backendDir.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'database.sqlite';
                if (! file_exists($dbFile)) {
                    touch($dbFile);
                }
            }

            spin(
                callback: function () use ($backendDir): void {
                    $migrateProcess = new Process(['php', 'artisan', 'migrate', '--seed', '--force'], $backendDir);
                    $migrateProcess->setTimeout(180);
                    $migrateProcess->run();
                },
                message: 'Running database migrations and demo seeders...'
            );
        }

        outro('🎉 Your Reyhan Commerce headless store is ready!');

        note(<<<TEXT
Next steps to launch your store:
  1. cd {$name}/backend
  2. php artisan serve

Admin Backoffice:    http://localhost:8000/admin (Default staff: admin@reyhan.test / password)
OpenAPI Reference:   http://localhost:8000/docs/api
TEXT);

        return Command::SUCCESS;
    }

    private function copyTemplateDirectory(string $source, string $destination): void
    {
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($items as $item) {
            $target = $destination.DIRECTORY_SEPARATOR.$items->getSubPathname();
            if ($item->isDir()) {
                if (! is_dir($target)) {
                    mkdir($target, 0755, true);
                }
            } else {
                copy($item->getPathname(), $target);
            }
        }
    }

    private function configureEnvironment(string $targetDir, string $name, string $driver): void
    {
        $envPath = $targetDir.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'.env';
        $exampleEnv = $targetDir.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'.env.example';

        if (! file_exists($exampleEnv)) {
            $envPath = $targetDir.DIRECTORY_SEPARATOR.'.env';
            $exampleEnv = $targetDir.DIRECTORY_SEPARATOR.'.env.example';
        }

        if (file_exists($exampleEnv) && ! file_exists($envPath)) {
            copy($exampleEnv, $envPath);
        }

        if (file_exists($envPath)) {
            $content = (string) file_get_contents($envPath);
            $content = preg_replace('/APP_NAME=.*/', "APP_NAME=\"{$name}\"", $content);
            $content = preg_replace('/DB_CONNECTION=.*/', "DB_CONNECTION={$driver}", $content);

            if ($driver === 'pgsql') {
                $content = preg_replace('/DB_PORT=.*/', 'DB_PORT=5432', $content);
            } elseif ($driver === 'mysql') {
                $content = preg_replace('/DB_PORT=.*/', 'DB_PORT=3306', $content);
            }

            file_put_contents($envPath, $content);
        }
    }
}
