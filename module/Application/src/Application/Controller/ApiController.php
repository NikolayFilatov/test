<?php

namespace Application\Controller;

use Application\Entity\Wall\WallService;

use Application\Entity\User\ZfcUser;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

use Zend\View\Model\JsonModel;

class ApiController extends AbstractActionController
{
    protected $em;
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
    public function walldeleteAction()	//нужно проверка на то может ли пользователь удалять
    {
    	if($this->getRequest()->isPost())
		{
			$em = $this->getEntityManager();

			$param = $this->getRequest()->getContent();
			
			$param = explode("&", $param);
			$p = [];
			foreach ($param as $par)
			{
				$par = explode("=", $par);
				$p[] = $par[1];
			}
			
			$id = $p[0];
			$type = $p[1];
			
			
			
			if($type == 'wall'){
				$wallService = new WallService($em);
				$wall = $wallService->getWallById($id);
				$wallService->delete($wall);
			} elseif($type == 'wall_comment'){
				$wallService = new WallService($em);
				$comment = $wallService->getWallCommentById($id);
				$wallService->delete($comment);
			}
			
			$result = [];			
			$vm = new JsonModel($result);
			return $vm;
		}  	
    }

}
