<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Http\JsonResponse;

class EntityController extends Controller
{
    public function getByCategory(EntityService $entityService, $categoryName): JsonResponse
    {
        $entities = $entityService->getByCategory($categoryName);

        return response()->json([
            'success' => true,
            'data' => $entities->map(function (Entity $entity) {
                return [
                    'api' => $entity->api,
                    'description' => $entity->description,
                    'link' => $entity->link,
                    'category' => [
                        'id' => $entity->category->id,
                        'category' => $entity->category->name
                    ],
                ];
            }),
        ]);
    }
}
