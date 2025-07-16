<?php

namespace App\Services\Concretes;

use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\Base\Concretes\BaseService;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService implements UserServiceInterface
{
    /**
     * UserService constructor.
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        $this->setRepository($userRepository);
    }

    /**
     * Get all users
     */
    public function getUsers(): Collection
    {
        return $this->repository->getFiltered();
    }

    /**
     * Get all users
     */
    public function getAllUsers(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Get filtered users with pagination
     */
    public function getFilteredUsers(?Request $request = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($perPage);
    }

    /**
     * Get user by ID
     */
    public function getUserById(int $id): ?Model
    {
        try {
            return $this->repository->findOrFail($id);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('User not found');
        }
    }

    /**
     * Create user
     */
    public function createUser(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update user
     */
    public function updateUser(int $id, array $data): Model
    {
        try {
            return $this->repository->update($id, $data);
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('User not found');
        }
    }

    /**
     * Delete user
     */
    public function deleteUser(int $id): bool
    {
        try {
            $this->repository->delete($id);

            return true;
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException('User not found');
        }
    }

    /**
     * Get active users
     */
    public function getActiveUsers(): Collection
    {
        return $this->userRepository->getActiveUsers();
    }
}
