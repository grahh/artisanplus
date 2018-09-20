<?php

namespace Grahh\Artisanplus\Contracts;


use Illuminate\Support\Collection;

interface RepositoryCRUD
{
    public function create(): void;
    public function read(): ?Collection;
    public function update(): void;
    public function delete(): void;
}