<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishService;
use Application\Entity\Price\PriceService;
use Application\Entity\User\ZfcUser;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\JsonModel;

class ApiController extends AbstractActionController
{
    protected $em;
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    
    public function updateCatalogAction()
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
            $data = urldecode($p[1]);
            $type = $p[2];

            switch($type)
            {
                case 'group':
                    $groupService = new DishGroupService($em);
                    $group = $groupService->getGroupById($id);
                    $group->setName($data);
                    $groupService->save($group);
                    break;
                case 'name':
                    $dishService = new DishService($em);
                    $dish = $dishService->getDishById($id);
                    $dish->setName($data);
                    $dishService->save($dish);
                    break;
                case 'cost':
                    $date = $this->DateFormat()->getCurDay();

                    $dishService = new DishService($em);
                    $dish = $dishService->getDishById($id);

                    $priceService = new PriceService($em);
                    $price = $priceService->createPrice(
                        $dish,
                        $data,
                        $date
                    );
                    break;
            }

			$result = [
                'id' => $id,
                'type' => $type,
                'data' => $data,
            ];
			$vm = new JsonModel($result);
			return $vm;
		}  	
    }

    public function removeDishAction()
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

            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);
            $dishService->delete($dish);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function removeDishGroupAction()
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

            $dishGroupService = new DishGroupService($em);
            $group = $dishGroupService->getGroupById($id);
            $dishGroupService->delete($group);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function addDishGroupAction()
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
            $name = urldecode($p[0]);

            $groupService = new DishGroupService($em);
            $groupService->createDishGroup(['name' => $name]);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function addDishAction()
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

            $groupService = new DishGroupService($em);
            $group = $groupService->getGroupById($id);

            $dishService = new DishService($em);
            $dishService->createDish([
                'name' => 'Новое блюдо',
                'group' => $group
            ]);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }
}
