<?php

namespace Grahh\Artisanplus\Base;


use Grahh\Artisanplus\Contracts\RepositoryCRUD;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements RepositoryCRUD, Arrayable, Jsonable
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->model->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->model->toJson($options);
    }

    public function create(array $data): void
    {
        try {
            $this->model->create($data);
        } catch (\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    public function read(int $key): ?Collection
    {
        try {
            $this->model->find($key);
        } catch (\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    public function update(array $data): void
    {
        try {
            $this->model->update($data);
        } catch (\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete(int $key): void
    {
        try {
            $this->model->delete($key);
        } catch (\Exception $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }
    }

    public function find(int $key)
    {
        return $this->read($key);
    }
}