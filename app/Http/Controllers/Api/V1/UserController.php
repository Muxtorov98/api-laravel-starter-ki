<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User management endpoints"
 * )
 */
class UserController extends BaseApiController
{
    public function __construct(
        protected readonly UserServiceInterface $userService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="List users with filters and pagination",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User list retrieved successfully"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getFilteredUsers(request());
        return $this->successResponse(UserResource::collection($users));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/all",
     *     summary="Get all users (without pagination)",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="All users retrieved successfully"
     *     )
     * )
     */
    public function all(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return $this->successResponse(UserResource::collection($users));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Get user by ID",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved successfully"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);
        return $this->successResponse(new UserResource($user));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully"
     *     )
     * )
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return $this->createdResponse(new UserResource($user));
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     summary="Update an existing user",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Jane Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="jane@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully"
     *     )
     * )
     */
    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return $this->successResponse(new UserResource($user));
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User deleted successfully"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return $this->noContentResponse();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/active",
     *     summary="Get active users",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Active users retrieved successfully"
     *     )
     * )
     */
    public function active(): JsonResponse
    {
        $users = $this->userService->getActiveUsers();
        return $this->successResponse(UserResource::collection($users));
    }
}
