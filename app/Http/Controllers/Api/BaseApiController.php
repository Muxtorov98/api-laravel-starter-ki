<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="api-starter-kit",
 *         description="Api starter kit. Created by Muxtorov Tulqin.",
 *         termsOfService="https://example.com/terms",
 *         @OA\Contact(
 *             name="Support Team",
 *             url="https://example.com/support",
 *             email="support@example.com"
 *         ),
 *         @OA\License(
 *             name="MIT License",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),

 *     @OA\Server(
 *         url="http://localhost:8015",
 *         description="Local HTTP Server"
 *     ),
 *     @OA\Server(
 *         url="https://api.example.com",
 *         description="Production HTTPS Server"
 *     ),

 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="Bearer",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT",
 *             description="Use JWT Bearer Token in the Authorization header. Format: Bearer {your-token}"
 *         )
 *     )
 * )
 */

class BaseApiController extends Controller
{
    use ApiResponse;
}
