<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
       
        //listener for check ZfcAuth
        $eventManager->getSharedManager()
        	->attach(__NAMESPACE__, 'dispatch', array($this, 'checkZfcUserAuth'), 100);
        
        //set session parameters from array in module.config.php
        $config = $e->getApplication()->getServiceManager()->get('config');
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config['session']);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
        
        //event for set locale for traslator
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'setLocale'));

    }
    //function for set translator locale
    public function setLocale(MvcEvent $e) {
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale('ru_RU');
        
    }
    
    //function for check ZfcAuth
    public function checkZfcUserAuth(MvcEvent $e) {
        $sm = $e->getApplication()->getServiceManager();
        $ZfcServ = $sm->get('zfcuser_auth_service');
        if (!$ZfcServ->hasIdentity()) {
            $pm = $sm->get('Zend\Mvc\Controller\PluginManager');
            return $pm->get('redirect')->toRoute('zfcuser/login');
            
        } else {
            if (is_object($ZfcServ->getIdentity()->getGroup())) {
                $group = $ZfcServ->getIdentity()->getGroup()->getName();
            } else {
                $group = "guest";
            }
            $this->GeoAcl($e, $group);
        }
    }
    //for check gropp and get access from acl.config.php via GeoAcl plugin
    public function GeoAcl($e, $group) {
        $sm = $e->getApplication()->getServiceManager();
        $pm = $sm->get('Zend\Mvc\Controller\PluginManager');
        $acl = $pm->get('GeoAcl');
        $acl->check($e, $group);
    }


    //for override default Zfc view scripts
    public function init($moduleManager)
    {
        $moduleManager->loadModule('ZfcUser');
        
    }
    
    public function getConfig()
    {
    	$module = require __DIR__ . '/config/module.config.php';
    	$router = require __DIR__ . '/config/router.config.php';
    	$user = require __DIR__ . '/config/user.config.php';
        $acl = require __DIR__ . '/config/acl.config.php';
    	
    	$config = array_merge_recursive($module, $router, $user, $acl);
        return $config;
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                 'Wall' => function($sm) {
                    $viewHelper = new \Application\ViewHelper\Wall($sm);
                    return $viewHelper;
                 }
            )
        );
        
    }
}
