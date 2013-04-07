<?php
namespace Application\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;

class GeoAcl extends AbstractPlugin {
	
    function __construct() {
    }
    
    function check($e, $group) {
        $acl = new Acl();
        
        //get configure file 
        $sm = $e->getApplication()->getServiceManager();
        $config = $sm->get('config')['GeoAcl'];
        
        $acl->addRole(new Role('guest'));
        $acl->addRole(new Role('user'), 'guest');
        $acl->addRole(new Role('moderator'), 'user');
        $acl->addRole(new Role('admin'));
        
        foreach ($config as $group_value) {
            foreach ($group_value as $key => $val) {
                
                $acl->allow($key, null, $val['permission']);
            }
            
        }
       
        if ($acl->isAllowed($group, null, $e->getRouteMatch()->getMatchedRouteName())) {
            return;
        } else {
            $sm = $e->getApplication()->getServiceManager();
            $pm = $sm->get('Zend\Mvc\Controller\PluginManager');
            return $pm->get('redirect')->toRoute('deny');
           
        }
    }
}

