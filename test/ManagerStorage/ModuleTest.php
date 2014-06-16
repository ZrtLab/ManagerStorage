<?php

namespace ManagerStorage\Tests;

class ModuleTest extends BaseModuleTest
{

    public function testConfig()
    {
        $this->assertNotEmpty($this->config);
        $this->assertInternalType('array', $this->config);
    }

    public function testConfigService()
    {
        $this->assertArrayHasKey('service_manager', $this->config);
        $this->assertNotEmpty($this->config['service_manager']);
    }

    public function testServices()
    {

        $this->assertArrayHasKey('ManagerStorage\Adapter\Session', $this->serviceManager->getCanonicalNames());
    }

    public function tearDown()
    {
        parent::tearDown();
    }

}
