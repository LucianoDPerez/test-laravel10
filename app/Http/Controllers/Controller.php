<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      version="0.1",
 *      title="Test Lucho",
 *      description="",
 *      @OA\Contact(
 *          email="lucianoperezvic84@gmail.com"
 *      )
 *  )
 * @OA\Server(url="/api/")
 * @OA\SecurityScheme(
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      securityScheme="BearerAuth",
 * )
 * @OA\OpenApi(
 *      security={
 *          {"BearerAuth": {}},
 *      }
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
