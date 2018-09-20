<?php

namespace Grahh\Artisanplus;


use Illuminate\Support\Str;

class ApplicationConfigurator
{
    protected $servicePath;
    protected $repositoryPath;

    public function setServicesPath(string $path = null): void
    {
        $this->servicePath = $path ?? app_path('Services');
    }

    public function setRepositoriesPath(string $path = null): void
    {
        $this->repositoryPath = $path ?? app_path('Repositories');
    }

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

    public function  getServicesPath(): string
    {
        return $this->servicePath;
    }

    public function  getRepositoriesPath(): string
    {
        return $this->repositoryPath;
    }

    public function prepareNamespace(string $namespace): string
    {
        try {
            $ns = explode('\\',$namespace);
            foreach ($ns as &$part) {
                if(!preg_match('/^[a-zA-Z]{1,}$/',$part)) {
                    throw new \Exception(sprintf("String %s is not a namespace",implode('\\',$ns)));
                }
                $part = Str::studly($part);
            }
            $ns = implode('\\',$ns);
            return $ns;
        } catch (\Exception $e) {
            echo ($e->getMessage());
            die();
        }
    }
}