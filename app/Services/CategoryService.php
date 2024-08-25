<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Entity;

class CategoryService
{

    public function all()
    {
        return Category::all();
    }
}
