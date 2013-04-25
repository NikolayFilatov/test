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

        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $events->attach('ZfcUser\Form\Register','init', function($e) {
            $form = $e->getTarget();
            $form->add(array(
                'name' => 'username',
                'attributes' => array(
                    'type'  => 'text',
                ),
                'options' => array(
                    'label' => 'Ваше имя',
                ),
            ));
            // Do what you please with the form instance ($form)
        });

        $events->attach('ZfcUser\Form\RegisterFilter','init', function($e) {
            $filter = $e->getTarget();

            $filter->add(array(
                'name'       => 'username',
                'required'   => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 255,
                        ),
                    ),
                ),
            ));
        });


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
        }
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
    	
    	$config = array_merge_recursive($module, $router, $user);
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
