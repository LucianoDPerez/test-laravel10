<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Entity;
use App\Models\Category;
use App\Services\ApiService;
use Illuminate\Support\Str;


class PopulateEntitiesCommand extends Command
{
    protected $signature = 'entities:populate';
    protected $description = 'Populate entities from the public API';

    public function handle()
    {
        // Starting title
        $this->info('Starting the process of populating entities...');

        // Confirmation message
        if (!$this->confirm('All existing records in the entities table will be deleted and reloaded. Are you sure you want to continue?')) {
            $this->info('Process aborted. No changes were made.');
            return;
        }

        try {
            // Fetch data from the API
            $entities = ApiService::getEntries();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        // Extract unique categories from the API response
        $categoriesFromApi = collect($entities['entries'])->pluck('Category')->unique()->toArray();

        // Get the categories to process efficiently
        $categoriesToProcess = Category::whereIn('name', $categoriesFromApi)->pluck('id', 'name')->toArray();

        // Array for entities to create
        $entitiesToCreate = [];
        $validEntitiesCount = 0;
        $totalEntitiesCount = count($entities['entries']);

        foreach ($entities['entries'] as $entity) {
            if (isset($categoriesToProcess[$entity['Category']])) {
                $categoryId = $categoriesToProcess[$entity['Category']];
                $entitiesToCreate[] = [
                    'id' => Str::uuid(),
                    'api' => $entity['API'],
                    'description' => $entity['Description'],
                    'link' => $entity['Link'],
                    'category_id' => $categoryId,
                ];
                $validEntitiesCount++;
            }
        }

        // Truncate the entities table before inserting new records
        Entity::truncate();

        // Insert the entities into the database
        foreach ($entitiesToCreate as $data) {
            Entity::create($data);
        }

        // Final message indicating the number of records inserted
        $this->info("Number of records inserted into the database: $validEntitiesCount");
    }
}
