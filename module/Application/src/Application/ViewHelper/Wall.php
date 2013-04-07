<?php

namespace Application\ViewHelper;

use Zend\XmlRpc\Value\DateTime;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

/**
 * Wall view helper
 */
class Wall extends AbstractHelper implements ServiceLocatorAwareInterface
{
    protected $sm;
    protected $em;
    protected $serviceLocator;
        
    public function __construct($sm) {
        $this->sm = $sm;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    /**
     * Invoke translation helper
     *
     * @param array $arr array of options for the map
     * @return string finished map HTML
     */
    public function __invoke($data, $param) {

    	$this->getView()->headScript()->appendFile('/js/wall.js');
			
    	$vm = new ViewModel(['data' => $data, 'param' => $param]);
    	$vm->setTemplate('application/viewhelper/wall_template');
    	
    	return $this->getView()->render($vm);    	
    }


}