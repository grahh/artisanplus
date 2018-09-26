<?php

namespace Grahh\Artisanplus\Contracts;


use Illuminate\View\View;

interface ShouldReturnView
{
    public function returnViewIfExists(string $path, $dto = []): View;
}