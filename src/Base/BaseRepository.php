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

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    public function read(): ?Collection
    {
        // TODO: Implement read() method.
    }

    public function update(): void
    {
        // TODO: Implement update() method.
    }

    public function delete(): void
    {
        // TODO: Implement delete() method.
    }
}