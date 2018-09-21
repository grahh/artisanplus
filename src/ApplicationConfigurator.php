<?php

namespace Grahh\Artisanplus;


use Illuminate\Support\Str;

class ApplicationConfigurator
{
    public function namespaceToPath(string $namespace):string
    {
        $basens = app()->getNamespace();
        $regex = '/'.$basens.'\\/';

        if(preg_match($regex,$namespace)) {
            $namespace = preg_replace($regex,'',$namespace);
        }

        $namespace = collect(explode("\\",$namespace))->map(function ($content) {
            return Str::studly($content);
        })->implode('/');
        return $namespace;
    }

    public function pathToNamespace(string $path): string
    {
        return str_replace('/','\\',$path);
    }
}