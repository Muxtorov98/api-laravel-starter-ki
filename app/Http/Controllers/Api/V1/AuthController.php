<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    /**
     * AuthController constructor.
     */
    public function __construct(
        private readonly AuthServiceInterface $authService
    ) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());

        return $this->successResponse($data);
    }

    /**
     * Login a user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        return $this->successResponse($data);
    }

    /**
     * Get the authenticated user.
     */
    public function me(): JsonResponse
    {
        $user = $this->authService->me();

        return $this->successResponse(new UserResource($user));
    }

    /**
     * Refresh the token.
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
     * Logout the user.
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->successResponse(['message' => 'Successfully logged out']);
    }
}
