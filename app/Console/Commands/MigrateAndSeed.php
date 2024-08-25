<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateAndSeed extends Command
{
    protected $signature = 'migrate:and-seed';
    protected $description = 'Run migrations and seed the database if necessary';

    public function handle()
    {
        try {
            // Run migrations
            $this->info('Running migrations...');
            Artisan::call('migrate', ['--force' => true]); // Use --force for production
            $this->info(Artisan::output());

            // Seed the database
            $this->info('Seeding the database...');
            Artisan::call('db:seed', ['--force' => true]); // Use --force for production
            $this->info(Artisan::output());

            $this->info('Migrations and seeding completed successfully.');

        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            return 1; // Return error code
        }

        return 0; // Return success code
    }
}
