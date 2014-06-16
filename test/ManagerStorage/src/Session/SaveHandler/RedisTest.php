<?php

namespace LammStorage\Tests\Session\SaveHandler;

use LammStorage\Session\SaveHandler\Redis,
    LammStorage\Tests\BaseModuleTest;

class RedisTest extends BaseModuleTest
{

    protected $redis;

    public function setUp()
    {
        parent::setUp();
        $this->redis = new Redis();
        $this->redis->setStorage($this->serviceManager->get('predisclient'));
    }

    public function testPredisClient()
    {
        $this->assertNotEmpty($this->serviceManager->get('PredisClient'));
    }

    public function testInstance()
    {
        $this->assertInstanceOf('LammStorage\Session\SaveHandler\Redis', $this->redis);
        $this->assertInstanceOf('Zend\Session\SaveHandler\SaveHandlerInterface', $this->redis);
    }

    public function testGetPredis()
    {
        $this->assertInstanceOf('LammRedis\PredisClient', $this->redis->getStorage());
    }

    public function testOpen()
    {
        $this->assertTrue($this->redis->open(null,'luis'));

        return "testOpen";
    }

    public function testClose()
    {
        $this->assertTrue($this->redis->close());
    }

    /**
     *
     * @depends testOpen
     */
    public function testRead()
    {
        $depends = array(
            'testOpen'
        );

        $this->assertEquals($depends, func_get_args());
        $id = 'test';
        $data = 'data';
        $this->redis->open(null, 'luis');
        $this->redis->write($id, $data);
        $idSession = $this->redis->getId();
        $this->assertEquals($this->redis->getStorage()->get($idSession), $data);

        return "testRead";
    }

    /**
     *
     * @depends testOpen
     */
    public function testGetId()
    {
        $depends = array(
            'testOpen'
        );

        $this->assertEquals($depends, func_get_args());

        $id = 'test';
        $data = 'data';
        $this->redis->open(null, 'luis');
        $this->redis->write($id, $data);
        $idSession = $this->redis->getId();
        $this->assertEquals($idSession, 'session:luis:test');
    }

    /**
     *
     * @depends testRead
     */
    public function testDestroy()
    {
        $depends = array(
            'testRead'
        );

        $this->assertEquals($depends, func_get_args());

        $id = 'test';
        $data = 'data';
        $this->redis->open(null, 'luis');
        $this->redis->write($id, $data);
        $idSession = $this->redis->getId();
        $this->assertTrue($this->redis->getStorage()->del($idSession) == 1);
        $this->assertEmpty($this->redis->getStorage()->get($idSession));
    }

}
