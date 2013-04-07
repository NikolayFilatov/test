<?php

namespace Application\Controller;

use Application\Entity\Wall\WallService;

use Application\Entity\Wall\UserWallComment;

use Application\Entity\Wall\UserWall;

use Application\Form\WallForm;

use Application\Entity\User\UserContact;

use Application\Entity\User\UserBagService;
use Application\Entity\User\ZfcUser;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Form\WallFilter;

class MyController extends AbstractActionController
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
    	$user = $this->zfcUserAuthentication()->getIdentity();
		return $this->redirect()->toRoute('my/wall', ['param' => $user->getId()]);
    }

    public function wallAction()
    {
		$em = $this->getEntityManager();
 		$user = $this->zfcUserAuthentication()->getIdentity();
		$userService = new UserService($em);
		
		$id = $this->getEvent()->getRouteMatch()->getParam('param');
		$userPage = $user;
		if ($id)
			$userPage = $userService->getUserById($id);
		
		$wallForm = new WallForm();
        $request = $this->getRequest();
		if ($request->isPost()) {
			$filter = new WallFilter();
			$wallForm->setInputFilter($filter->getInputFilter());
			$wallForm->setData($request->getPost());
			if($wallForm->isValid()) {
				$post = $wallForm->getData();
				
				if (isset($post['idMess'])){ //если есть это поле то мы добавляем комментарий
					$wallService = new WallService($em);
					$wall = $wallService->getWallById($post['idMess']);
					
					$wallComment = new UserWallComment([
							'message' => $post['cmessage'],
							'autor' => $user,
							]);
					
					$wall->addComment($wallComment);
					$wallService->save($wall);
					
				} elseif(isset($post['idUser'])){ //добавляем сообщение на стену
					$wall = new UserWall([
							'message' => $post['message'],
							'autor' => $user,
							]);
					
					$userService = new UserService($em);
					$userPage = $userService->getUserById($post['idUser']);
					
					$userPage->addWall($wall);
					$userService->save($userPage);
				}
			}
		}
		
		$wallForm->setData(['message' => '', 'cmessage' => '']);
		
		$walls = $userService->getWall($userPage);//->getWall($userPage, 'DESC', 1, 3, 'limit');
		
		$permission = 'guest';
		if ($user == $userPage)
			$permission = 'host';
			
        $vm = new ViewModel(
        		['user' 	=> $userPage,
        		 'form' 	=> $wallForm,
        		 'wall' 	=> $walls,
        		 'param' 	=> [
        				'permission' => $permission,
        				'form' => $wallForm,
        			],
        		]
        	);
        $vm->setTemplate('application/my/my_wall');
        
        return $vm;   	 
    }

    public function settAction()
    {
    	$em = $this->getEntityManager();
    	$user = $this->zfcUserAuthentication()->getIdentity();
    	$userService = new UserService($em);
    	
    	$id = $this->getEvent()->getRouteMatch()->getParam('param');
    	$userPage = $user;
    	if ($id)
    		$userPage = $userService->getUserById($id);

    	
    	if ($user != $userPage)
    	{
    		$this->redirect()->toRoute('my/wall/', ['param' => $id]);
    		return;
    	}
    		
    	$vm = new ViewModel(
    			['user' => $userPage,
    			]
    	);
    	$vm->setTemplate('application/my/my_sett');
    	
    	return $vm;
    }

    public function resAction()
    {
    	$em = $this->getEntityManager();
    	$user = $this->zfcUserAuthentication()->getIdentity();
    	$userService = new UserService($em);
    	
    	$id = $this->getEvent()->getRouteMatch()->getParam('param');
    	$userPage = $user;
    	if ($id)
    		$userPage = $userService->getUserById($id);
    	    	
    	
		
		$my_wall = false;
		if ($user == $userPage)
			$my_wall = true;
			
        $vm = new ViewModel(
        		['user' => $userPage,
        		 'my_wall' => $my_wall,
        		]
        	);
    	$vm->setTemplate('application/my/my_res');
    	
    	return $vm;    	 
    }

    public function specAction()
    {
    	$em = $this->getEntityManager();
    	$user = $this->zfcUserAuthentication()->getIdentity();
    	$userService = new UserService($em);
    	
    	$id = $this->getEvent()->getRouteMatch()->getParam('param');
    	$userPage = $user;
    	if ($id)
    		$userPage = $userService->getUserById($id);
    	
    	
		
    	if ($user != $userPage)
    	{
    		$this->redirect()->toRoute('my/wall/', ['param' => $id]);
    		return;
    	}
			
        $vm = new ViewModel(
        		['user' => $userPage,
        		]
        	);
    	$vm->setTemplate('application/my/my_spec');
    	
    	return $vm;    	 
    }

}
