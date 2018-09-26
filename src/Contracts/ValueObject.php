<?php

namespace Grahh\Artisanplus\Contracts;


interface ValueObject
{
    public function __get(string $name);

    public function __isset($k);
    public function __unset($k);
    public function __clone();
    public function __toString(): string;
    public function __call($k,$v);
    public static function __callStatic($k,$v);
    public function __sleep();
    public function __wakeup();
    public function __invoke();
    public function __destruct();
    public function __set_state();
    public function __debuginfo();
}