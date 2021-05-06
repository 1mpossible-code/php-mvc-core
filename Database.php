<?php


namespace app\core;


use PDO;
use PDOStatement;

/**
 * Class Database
 * @package app\core
 */
class Database
{
    /**
     * PDO database driver
     * @var PDO
     */
    public PDO $PDO;

    /**
     * Database constructor.
     */
    public function __construct(array $config)
    {
        // Get dsn, user and password from config file
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        // Create new PDO connection
        $this->PDO = new PDO($dsn, $user, $password);
        // Set error mode to exceptions
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Apply new migrations
     */
    public function applyMigrations(): void
    {
        // Create migrations table
        $this->createMigrationsTable();
        // Get applied migrations
        $appliedMigrations = $this->getAppliedMigrations();

        // Array for new migrations
        $newAppliedMigrations = [];
        // Get all files from migrations directory
        $files = scandir(Application::$ROOT_DIR . '/migrations');
        // Select all not yet applied migrations
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        // Apply each not applied migration
        foreach ($toApplyMigrations as $migration) {
            // Files array may contain '.' and '..' elements
            // that are not migrations, so skip them
            if ($migration === '.' || $migration === '..') {
                // Continue loop
                continue;
            }
            // Require current migration class
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            // Get migration classname with the help of cutting the extension
            $className = pathinfo($migration, PATHINFO_FILENAME);
            // Create an instance of migration class
            $instance = new $className();
            // Log starting applying migration
            $this->log("Applying migration $migration");
            // Call migration up
            $instance->up();
            // Log success if has not any errors
            $this->log("Successfully applied migration $migration!");
            // Add success migration to new applied migrations array
            $newAppliedMigrations[] = $migration;
        }
        // Save all migrations to migrations table if
        // exist, else log that nothing to migrate
        if (!empty($newAppliedMigrations)) {
            // Save new migrations to database migration table
            $this->saveMigrations($newAppliedMigrations);
        } else {
            // Log that everything is already applied
            $this->log("All migrations are applied");
        }
    }

    /**
     * Create 'migrations' table if not exists
     */
    public function createMigrationsTable(): void
    {
        // Execute SQL statement that creates migrations table
        // if not exists with PDO driver
        $this->PDO->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
    }

    /**
     * Get already applied migrations
     * @return mixed
     */
    public function getAppliedMigrations()
    {
        // Prepare selection of all migration
        // name from migrations table
        $statement = $this->prepare("SELECT migration FROM migrations");
        // Execute statement
        $statement->execute();
        // Return migration names in array
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Save migration names from given array
     * to migrations table
     * @param array $migrations
     */
    public function saveMigrations(array $migrations)
    {
        // Convert migrations array to string and
        // prepare them to be executed by SQL
        $str = implode(',', array_map(static fn($m) => "('$m')", $migrations));
        // Prepare statement to insert each
        // new migration to migrations table
        $statement = $this->prepare("insert into migrations (migration) values
            $str
            ");
        // Execute prepared statement
        $statement->execute();
    }

    /**
     * Prepare PDO statement
     * @param $sql
     * @return false|PDOStatement
     */
    public function prepare($sql)
    {
        // Return prepared PDO
        return $this->PDO->prepare($sql);
    }

    /**
     * Print given message as a log
     * @param $message
     */
    protected function log($message)
    {
        // Print log with date
        echo '[' . date('d-m-Y H:i:s') . '] - ' . $message . PHP_EOL;
    }
}