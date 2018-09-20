<?php

namespace Grahh\Artisanplus\Base;


use Grahh\Artisanplus\Contracts\Activatable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

abstract class BaseService implements Arrayable, Jsonable, Activatable
{
    protected $results;
    protected $active;
    protected $messages;

    public function __construct()
    {
        $this->results = collect();
        $this->messages = collect();
        $this->setActive(true);
    }

    public function toArray(): array
    {
        return $this->results->toArray();
    }

    public function toJson($options = 0): string
    {
        return $this->results->toJson($options);
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function isActive(): bool
    {
        return $this->active === true;
    }

    public function getMessage(string $key): string
    {
        if($this->messages->has($key)) {
            return $this->messages->get($key);
        } else {
            return $key;
        }
    }
}