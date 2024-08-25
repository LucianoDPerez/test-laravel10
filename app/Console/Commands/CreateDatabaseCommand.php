<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabaseCommand extends Command
{
    protected $signature = 'db:create'; // Command name | php artisan db:create
    protected $description = 'Create a new database in MySQL';

    public function handle()
    {
        // Get the database name from the command argument
        $dbName = 'test_luciano_perez';

        // Retrieve the connection settings from the .env file
        $host = config('database.connections.mysql.host');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Create a connection to the MySQL server
        $connection = new \mysqli($host, $username, $password);

        // Check the connection
        if ($connection->connect_error) {
            $this->error('Connection error: ' . $connection->connect_error);
            return;
        }

        // Create the database
        $sql = "CREATE DATABASE IF NOT EXISTS {$dbName}"; // Using IF NOT EXISTS to avoid errors if it already exists
        if ($connection->query($sql) === TRUE) {
            $this->info("Database '{$dbName}' created successfully.");
        } else {
            $this->error('Error creating database: ' . $connection->error);
        }

        // Close the connection
        $connection->close();
    }
}
