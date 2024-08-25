<?php

namespace App\Services;

use App\Models\Entity;

class EntityService
{
    public function getByCategory($name)
    {
        return Entity::with('category') // Eager load the category relationship
        ->whereHas('category', function ($query) use ($name) {
            $query->where(strtolower('name'), strtolower($name));
        })
            ->get();
    }
}
