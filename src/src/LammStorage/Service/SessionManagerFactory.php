<?php

namespace ManagerStorage\Service;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    ManagerStorage\Session\SaveHandler\Redis;

class SessionManagerFactory implements FactoryInterface
{
    protected $serviceLocator;
    protected $config;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $config = $this->serviceLocator->get('config');
        $configSessionManager = $config['ManagerStorage']['session_manager'];
        $this->config = $configSessionManager;

        return $this->factory();
    }

    protected function factory()
    {
        $params = $this->getIsActive();
        $adapter = new $params['Adapter']();
        $adapter->setStorage($this->serviceLocator->get($params['ServiceManager']));

        return $adapter;
    }

    private function getIsActive()
    {
        foreach ($this->config as $service) {
            if (isset($service['Active']) && $service['Active'] == true) {
                return $service;
            }
        }
        throw new \Exception('Error ningun Servicio esta activo', 500);
    }
}
