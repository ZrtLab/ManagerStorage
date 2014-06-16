<?php

return array(
    'ManagerStorage' => array(
        'session_manager' => array(
            'redis' => array(
                'Adapter' => 'ManagerStorage\Session\SaveHandler\Redis',
                'Factory' => 'ManagerStorage\Factory\Service\PredisServiceFactory',
                'ServiceManager' => 'PredisClient',
                'Active' => true
            )
        ),
        'cache_manager' => array()
    ),
    'service_manager' => array(
        'factories' => array(
            'ManagerStorage\Adapter\Session' => 'ManagerStorage\Service\SessionManagerFactory'
        )
    )
);
