<?php

namespace Application\Controller;

use Application\Entity\User\UserWall;
use Application\Entity\User\UserContact;
use Application\Entity\User\ZfcUser;

use Application\Entity\Groups\GroupsService;
use Application\Entity\Groups\Groups;

use Application\Entity\User\User;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class IndexController extends AbstractActionController
{
    protected $em;
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
    public function indexAction()
    {	
    	$em = $this->getEntityManager();
    	
    	$user = $this->zfcUserAuthentication()->getIdentity();
    	
    	
        $vm = new ViewModel();
        $vm->setTemplate('application/index/index');
        
        return $vm;
    }
    
    public function denyAction() {
       $vm = new ViewModel();
       return $vm;
    }
    public function firmsAction() {
        
    }
}
