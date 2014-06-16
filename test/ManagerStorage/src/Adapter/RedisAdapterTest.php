<?php

namespace ManagerStorage\Tests\Adapter;

use ManagerStorage\Cache\Storage\Adapter\Redis,
    ManagerStorage\Tests\Bootstrap,
    ManagerStorage\Tests\BaseModuleTest;

class RedisAdapterTest extends BaseModuleTest
{

    protected $redisAdapter;

    public function setUp()
    {
        $this->redisAdapter = new Redis;
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->assertNotEmpty($this->serviceManager);
    }

    public function testServiceManager()
    {
        $this->assertNotEmpty($this->serviceManager);
    }

    public function testInstances()
    {
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\AbstractAdapter', $this->redisAdapter);
        $this->assertInstanceOf('Zend\Cache\Storage\FlushableInterface', $this->redisAdapter);
    }

    public function setDown()
    {

    }

}
