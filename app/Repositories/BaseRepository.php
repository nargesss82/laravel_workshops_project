<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryRepository.
 *
 * @package namespace App\Repositories;
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected $model;
    public function __construct(Model $model){
        $this->model = $model;
    }

    public function all():Collection{
        return $this->model->all();
    }

    public function find(int $id):Model
    {
       return $this->model->findOrFail($id);
    }
    public function create(array $attributes):Model
    {
        return $this->model->create($attributes);
    }
    public function update(int $id, array $attributes):Model
    {
        $model = $this->find($id);
        $model->update($attributes);
        return $model;
    }

    public function delete(int $id):bool
    {
        $model = $this->find($id);
        return $model->delete();
    }
}
