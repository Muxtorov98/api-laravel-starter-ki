<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication related APIs"
 * )
 */
class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful registration",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());
        return $this->successResponse($data);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="Login a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-jwt-token"),
     *             @OA\Property(property="token_type", type="string", example="bearer")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());
        return $this->successResponse($data);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Authentication"},
     *     summary="Get the authenticated user",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user info",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->me();
        return $this->successResponse(new UserResource($user));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/refresh",
     *     tags={"Authentication"},
     *     summary="Refresh the token",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="New token returned",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-new-jwt-token"),
     *             @OA\Property(property="token_type", type="string", example="bearer")
     *         )
     *     )
     * )
     */
    public function refresh(): JsonResponse
    {
        $token = $this->authService->refresh();
        return $this->successResponse([
            'token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout the user",
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return $this->successResponse(['message' => 'Successfully logged out']);
    }
}
