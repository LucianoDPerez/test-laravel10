<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Entity;
use App\Services\CategoryService;
use App\Services\EntityService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * @OA\Get(
     *     path="/category/",
     *     summary="Get Categories",
     *     description="Get a list of categories",
     *     tags={"category"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categories not found"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->all());
    }
}
