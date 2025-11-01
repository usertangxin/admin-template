<?php

namespace Modules\Admin\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository
{
    protected Builder|Model $model;

    /**
     * Get all records
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Get paginated records
     */
    public function paginate(int $limit = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($limit, $columns);
    }

    /**
     * Find a record by its ID
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find a record by its ID or fail
     */
    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Create a new record
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->findOrFail($id);
        $record->update($data);

        return $record;
    }

    /**
     * Delete a record
     */
    public function delete(int $id): ?bool
    {
        $record = $this->findOrFail($id);

        return $record->delete();
    }

    /**
     * Get records by criteria
     */
    public function getByCriteria(array $criteria, array $columns = ['*']): Collection
    {
        $query = $this->model->newQuery();

        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get($columns);
    }

    /**
     * First or create a record
     */
    public function firstOrCreate(array $criteria, array $data = []): Model
    {
        return $this->model->firstOrCreate($criteria, $data);
    }

    /**
     * Update or create a record
     */
    public function updateOrCreate(array $criteria, array $data = []): Model
    {
        return $this->model->updateOrCreate($criteria, $data);
    }

    /**
     * Count records
     */
    public function count(array $criteria = []): int
    {
        $query = $this->model->newQuery();

        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }

        return $query->count();
    }

    /**
     * Get a new query builder
     *
     * @return Builder|Model
     */
    public function newQuery()
    {
        return $this->model->newQuery();
    }
}
