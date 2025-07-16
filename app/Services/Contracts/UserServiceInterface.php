<?php

namespace App\Services\Contracts;

use App\Services\Base\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface extends BaseServiceInterface
{
    public function getUsers(): Collection;

    public function getAllUsers(): Collection;

    public function getFilteredUsers(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    public function getUserById(int $id): ?Model;

    public function createUser(array $data): Model;

    public function updateUser(int $id, array $data): Model;

    public function deleteUser(int $id): bool;

    public function getActiveUsers(): Collection;
}
