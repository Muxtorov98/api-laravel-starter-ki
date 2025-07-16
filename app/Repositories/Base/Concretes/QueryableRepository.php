<?php

namespace App\Repositories\Base\Concretes;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

abstract class QueryableRepository extends BaseRepository implements QueryableRepositoryInterface
{
    /**
     * Get a query builder instance with filters, sorts, and includes applied.
     */
    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters($this->getAllowedFilters())
            ->allowedSorts($this->getAllowedSorts())
            ->allowedFields($this->getAllowedFields())
            ->allowedIncludes($this->getAllowedIncludes());
    }

    /**
     * Get filtered, sorted, and included resources.
     */
    public function getFiltered(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    /**
     * Get paginated, filtered, sorted, and included resources.
     */
    public function paginateFiltered(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $perPage = request()->input('per_page', $perPage) ?? $perPage;

        return $this->query()->paginate($perPage, $columns);
    }

    /**
     * Get allowed filters for this repository.
     */
    public function getAllowedFilters(): array
    {
        return [];
    }

    /**
     * Get allowed sorts for this repository.
     */
    public function getAllowedSorts(): array
    {
        return [];
    }

    /**
     * Get allowed includes for this repository.
     */
    public function getAllowedIncludes(): array
    {
        return [];
    }

    /**
     * Get allowed fields for this repository.
     */
    public function getAllowedFields(): array
    {
        return [];
    }
}
