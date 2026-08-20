<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use PDO;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureDatabaseExists();
    }

    protected function ensureDatabaseExists(): void
    {
        $defaultConnection = config('database.default');

        if ($defaultConnection === 'sqlite') {
            $this->ensureSqliteDatabaseExists();

            return;
        }

        if (! in_array($defaultConnection, ['mysql', 'mariadb'], true)) {
            return;
        }

        try {
            DB::connection()->getPdo();
        } catch (Throwable $exception) {
            if (! $this->isUnknownDatabaseException($exception)) {
                return;
            }

            try {
                $this->createMysqlDatabase($defaultConnection);
            } catch (Throwable) {
                // DB server unreachable / wrong credentials — let the app fail later on real queries.
            }
        }
    }

    protected function ensureSqliteDatabaseExists(): void
    {
        $databasePath = config('database.connections.sqlite.database');

        if (! is_string($databasePath) || $databasePath === '' || $databasePath === ':memory:') {
            return;
        }

        $directory = dirname($databasePath);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (! file_exists($databasePath)) {
            touch($databasePath);
        }
    }

    protected function createMysqlDatabase(string $connectionName): void
    {
        $connection = config("database.connections.{$connectionName}");
        $database = $connection['database'] ?? null;
        $host = $connection['host'] ?? '127.0.0.1';
        $port = $connection['port'] ?? '3306';
        $username = $connection['username'] ?? '';
        $password = $connection['password'] ?? '';
        $charset = $connection['charset'] ?? 'utf8mb4';
        $collation = $connection['collation'] ?? 'utf8mb4_unicode_ci';

        if (! is_string($database) || trim($database) === '') {
            return;
        }

        $dsn = sprintf('mysql:host=%s;port=%s;charset=%s', $host, $port, $charset);

        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $pdo->exec(sprintf(
            'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET %s COLLATE %s',
            str_replace('`', '``', $database),
            $charset,
            $collation
        ));

        DB::purge($connectionName);
        DB::reconnect($connectionName);
    }

    protected function isUnknownDatabaseException(Throwable $exception): bool
    {
        $message = strtolower($exception->getMessage());

        return str_contains($message, 'unknown database')
            || str_contains($message, 'database does not exist');
    }
}
