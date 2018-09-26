<?php

$app_namespace = app()->getNamespace();
$app_namespace = preg_replace('/\\\/','',$app_namespace);

return [
    'commands' => [
        \Grahh\Artisanplus\Commands\MakeRepositoryCommand::class,
        \Grahh\Artisanplus\Commands\MakeServiceCommand::class,
        \Grahh\Artisanplus\Commands\MakeValueObjectCommand::class
    ],

    'namespaces' => [
        'models' => $app_namespace,
        'repositories' => $app_namespace."\\Repositories",
        'services' => $app_namespace."\\Services",
        'value_objects' => $app_namespace."\\Support\\ValueObjects",
    ],
];
