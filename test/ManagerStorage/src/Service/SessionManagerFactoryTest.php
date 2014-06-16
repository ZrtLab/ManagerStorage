<?php

namespace ManagerStorage\Tests\Service;

use ManagerStorage\Service\SessionManagerFactory,
    ManagerStorage\Tests\BaseModuleTest;

class SessionManagerFactoryTest extends BaseModuleTest
{

    public function testConfig()
    {
        $this->assertNotEmpty($this->config['ManagerStorage']);
    }

    public function testSessionManager()
    {
        $this->assertArrayHasKey('session_manager', $this->config['ManagerStorage']);
    }

    public function testCacheManager()
    {
        $this->assertArrayHasKey('cache_manager', $this->config['LammStorage']);
    }

    public function testSessionManagerRedis()
    {
        $config = array(
            'ManagerStorage' => array(
                'session_manager' => array(
                    'redis' => array(
                        'Adapter' => 'ManagerStorage\Session\SaveHandler\Redis',
                        'Factory' => 'RedisClient\Factory\Service\PredisServiceFactory',
                        'ServiceManager' => 'PredisClient',
                        'Active' => true
                    )
                )
            ),
            'service_manager' => array(
                'factories' => array(
                    'PredisClient' => 'RedisClient\Factory\Service\PredisServiceFactory'
                )
            )
        );

        $this->assertArrayHasKey('Active', $config['ManagerStorage']['session_manager']['redis']);
        $this->assertTrue($config['ManagerStorage']['session_manager']['redis']['Active']);

        $serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $this->assertInternalType('array', $config);

        $serviceLocator
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($config));

        $factory = new SessionManagerFactory();
        $this->assertNotEmpty($factory);

        $this->assertInstanceOf(
            'ManagerStorage\Session\SaveHandler\Redis',
            $factory->createService($serviceLocator)
        );

    }

}
