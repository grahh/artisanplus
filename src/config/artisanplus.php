<?php

return [
    'commands' => [
        \Grahh\Artisanplus\Commands\MakeRepositoryCommand::class,
        \Grahh\Artisanplus\Commands\MakeServiceCommand::class,
    ],

    'namespaces' => [
        'models' => "App",
        'repositories' => "App\\Repositories",
        'services' => "App\\Services",
    ]
];
