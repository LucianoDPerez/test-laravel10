<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\EntityController;
use App\Models\Category;
use App\Models\Entity;
use App\Services\EntityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class EntityControllerTest extends TestCase
{
    private $entityServiceMock;
    private $entityController;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for EntityService
        $this->entityServiceMock = Mockery::mock(EntityService::class);

        // Instantiate the EntityController with the mock
        $this->entityController = new EntityController($this->entityServiceMock);
    }

    public function testGetByCategoryReturnsJsonResponseWithCorrectLink()
    {
        // Create a mock category
        $category = new Category(['id' => 1, 'name' => 'Animals']);

        // Create a collection of entities with the mock category, making sure the relationship is set
        $entities = new Collection([
            (tap(new Entity(['api' => 'API 1', 'description' => 'Description 1', 'link' => 'http://web.archive.org/web/20240403172734if_/https://api.publicapis.org/entries', 'category_id' => $category->id]))->setRelation('category', $category)),
            (tap(new Entity(['api' => 'API 2', 'description' => 'Description 2', 'link' => 'https://example.com/2', 'category_id' => $category->id]))->setRelation('category', $category)),
        ]);

        // Mock the EntityService to return the collection of entities
        $this->entityServiceMock
            ->shouldReceive('getByCategory')
            ->once()
            ->with('Animals')
            ->andReturn($entities);

        // Call the getByCategory method
        $response = $this->entityController->getByCategory($this->entityServiceMock, 'Animals');

        // Assert that the response is a JsonResponse
        $this->assertInstanceOf(JsonResponse::class, $response);

        // Assert that the response content is as expected
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
        $this->assertCount(2, $responseData['data']);

        // Assert that the first entity's link matches the expected URL
        $this->assertEquals('http://web.archive.org/web/20240403172734if_/https://api.publicapis.org/entries', $responseData['data'][0]['link']);

        // Additional assertions for the first entity
        $this->assertEquals('API 1', $responseData['data'][0]['api']);
        $this->assertEquals('Description 1', $responseData['data'][0]['description']);
        $this->assertEquals(1, $responseData['data'][0]['category']['id'] ?? 1);
        $this->assertEquals('Animals', $responseData['data'][0]['category']['category']);

        // Assert that the second entity's link matches the expected URL
        $this->assertEquals('https://example.com/2', $responseData['data'][1]['link']);

        // Additional assertions for the second entity
        $this->assertEquals('API 2', $responseData['data'][1]['api']);
        $this->assertEquals('Description 2', $responseData['data'][1]['description']);
        $this->assertEquals(1, $responseData['data'][1]['category']['id'] ?? 1);
        $this->assertEquals('Animals', $responseData['data'][1]['category']['category']);

        // Assert that the status code is 200
        $this->assertEquals(200, $response->getStatusCode());
    }

}
