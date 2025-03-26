<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="E-commerce API",
 *         description="API Documentation for Product Management",
 *         @OA\Contact(email="support@example.com")
 *     ),
 *     @OA\Server(url="http://localhost:8000/api"),
 *     @OA\Components(
 *         @OA\Schema(
 *             schema="Product",
 *             ref="#/components/schemas/Product"
 *         )
 *     )
 * )
 */
class APIDocsController extends Controller
{
    // Controller exists for Swagger annotations only
}
