<?php

namespace Grahh\Artisanplus\Contracts;


use Illuminate\Support\Collection;

interface RepositoryCRUD
{
    public function create(array $data): void;
    public function read(int $key): ?Collection;
    public function update(array $data): void;
    public function delete(int $key): void;
}