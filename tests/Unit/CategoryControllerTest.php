<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\CategoryController;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    private $categoryServiceMock;
    private $categoryController;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for CategoryService
        $this->categoryServiceMock = Mockery::mock(CategoryService::class);

        // Instantiate the CategoryController with the mock
        $this->categoryController = new CategoryController($this->categoryServiceMock);
    }

    public function testIndexReturnsJsonResponse()
    {
        // Define the expected behavior of the mock
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
        ];

        $this->categoryServiceMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($categories);

        // Call the index method
        $response = $this->categoryController->index();

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response content is as expected
        $this->assertEquals($categories, $response->getData(true));

        // Assert that the status code is 200
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testIndexReturnsEmptyArrayWhenNoCategories()
    {
        // Define the expected behavior of the mock for the case when there are no categories
        $this->categoryServiceMock
            ->shouldReceive('all')
            ->once()
            ->andReturn([]);

        // Call the index method
        $response = $this->categoryController->index();

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response content is an empty array
        $this->assertEquals([], $response->getData(true));

        // Assert that the status code is 200
        $this->assertEquals(200, $response->getStatusCode());
    }
}
