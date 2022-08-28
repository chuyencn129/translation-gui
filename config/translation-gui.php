<?php

return [
    /**
     * The main language of the application, the lines of this language will be
     * filled by the exact key values by default.
     */
    'base_language' => 'en',

    /**
     * Configurations for the route group that serves the Langman Controller.
     */
    'route_group_config' => [
        'middleware' => ['admin.user'],
        'namespace' => '\Meesudzu\Translation'
    ]
];
