<?php

namespace App\Services\Base\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseServiceInterface
{
    public function getFiltered(array $columns = ['*']): Collection;

    /**
     * Get all resources
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Get paginated resources
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Find resource by id
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Find resource or fail
     */
    public function findOrFail(int $id, array $columns = ['*']): Model;

    /**
     * Create new resource
     */
    public function create(array $data): Model;

    /**
     * Update resource
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete resource
     */
    public function delete(int $id): bool;
}
