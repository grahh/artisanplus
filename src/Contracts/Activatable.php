<?php

namespace Grahh\Artisanplus\Contracts;


interface Activatable
{
    public function setActive(bool $active): void;
    public function isActive(): bool;
}