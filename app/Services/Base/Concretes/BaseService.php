<?php

namespace App\Services\Base\Concretes;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use App\Services\Base\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    protected QueryableRepositoryInterface $repository;

    public function setRepository(QueryableRepositoryInterface $repository): QueryableRepositoryInterface
    {
        return $this->repository = $repository;
    }

    public function getRepository(): QueryableRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * Get filtered, sorted, and included resources.
     */
    public function getFiltered(array $columns = ['*']): Collection
    {
        return $this->repository->getFiltered($columns);
    }

    /**
     * Get all resources
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    /**
     * Get paginated resources
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * Find resource by id
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Find resource or fail
     */
    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->repository->findOrFail($id, $columns);
    }

    /**
     * Create new resource
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update resource
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete resource
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
