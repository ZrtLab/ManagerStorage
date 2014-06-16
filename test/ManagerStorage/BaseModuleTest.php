<?php

namespace ManagerStorage\Tests;

use  ManagerStorage\Tests\Bootstrap;

abstract class BaseModuleTest extends \PHPUnit_Framework_TestCase
{

    protected $config;
    protected $serviceManager;

    public function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->config = $this->serviceManager->get('config');
    }

    public function testPredisClient()
    {
        $this->assertInstanceOf("Predis\Client",$this->serviceManager->get("PredisClient"));
    }

}
