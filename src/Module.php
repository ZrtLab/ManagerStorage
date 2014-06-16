<?php
namespace ManagerStorage;

use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\EventManager\EventInterface;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            )
        );
    }

    public function onBootstrap(EventInterface $evm)
    {
        $config = $evm->getApplication()
            ->getServiceManager()
            ->get('Configuration');

        $serviceLocator = $evm->getApplication()
            ->getServiceManager();

        $sessionManager = new SessionManager();
        $sessionManager->setSaveHandler($serviceLocator->get('ManagerStorage\Adapter\Session'));
        $sessionManager->start();

        Container::setDefaultManager($sessionManager);
    }
}
