<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\V1\UserStoreRequest;
use App\Http\Requests\Api\V1\UserUpdateRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class UserController extends BaseApiController
{
    /**
     * UserController constructor.
     */
    public function __construct(
        protected readonly UserServiceInterface $userService
    ) {}

    /**
     * Display a listing of the users with filtering, sorting, and pagination.
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getFilteredUsers(request());

        return $this->successResponse(UserResource::collection($users));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/all",
     *     summary="Get users list",
     *     tags={"Users"},
     *     security={{"Bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function all(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return $this->successResponse(UserResource::collection($users));
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return $this->successResponse(new UserResource($user));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return $this->createdResponse(new UserResource($user));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());

        return $this->successResponse(new UserResource($user));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->deleteUser($id);

        return $this->noContentResponse();
    }

    /**
     * Display a listing of active users.
     */
    public function active(): JsonResponse
    {
        $users = $this->userService->getActiveUsers();

        return $this->successResponse(UserResource::collection($users));
    }
}
