<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishService;
use Application\Entity\Menu\MenuService;
use Application\Entity\Order\OrderItemService;
use Application\Entity\Order\OrderService;
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
            $dish->markDelete();
            $dishService->save($dish);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function restoreDishAction()
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
            $dish->markUnDelete();
            $dishService->save($dish);

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

    public function createMenuCatalogAction()
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
            $timestamp = $p[0];


            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $dishGroupService = new DishGroupService($em);
            $groups = $dishGroupService->getAllDishGroup();
            $menuService = new MenuService($em);

            //проверим есть ли на эту дату пункты меню, если есть удалим.
            $menus = $menuService->getMenuByDate($date);
            foreach($menus as $menu)
            {
                $menuService->delete($menu);
            }

            foreach($groups as $group)
            {
                $dishs = $group->getDish();
                foreach($dishs as $dish)
                {
                    if (!$dish->isDeleted())
                        $menuService->createMenu([
                            'date' => $date,
                            'dish' => $dish,
                        ]);
                }
            }

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function excludeMenuAction()
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

            //исключим из меню на заданную дату пункт с id
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            $menu->markDelete();
            $menuService->save($menu);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function includeMenuAction()
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

            //исключим из меню на заданную дату пункт с id
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            $menu->markUnDelete();
            $menuService->save($menu);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function addItemToOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getContent();
            $param = explode("&", $param);
            $p = [];
            foreach ($param as $par)
            {
                $par = explode("=", $par);
                $p[] = $par[1];
            }
            $id = $p[0];
            $timestamp = $p[1];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            //ищем заказ этого юзера на эту дату.
            $orderService = new OrderService($em);
            $order = $orderService->findOrder([
                'user' => $user,
                'date' => $date,
            ]);

            //заказа нет, создадим его.
            if(!$order)
                $order = $orderService->createOrder([
                    'user' => $user,
                    'date' => $date,
                ]);

            if(is_array($order))
                $order = array_shift($order);

            //получим блюдо по id
            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);

            //создадим item для заказа и добавим его в заказ
            $orderItemService = new OrderItemService($em);
            $item = $orderItemService->createItem([
                'order' => $order,
                'dish' => $dish,
            ]);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }

    public function removeItemFromOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getContent();
            $param = explode("&", $param);
            $p = [];
            foreach ($param as $par)
            {
                $par = explode("=", $par);
                $p[] = $par[1];
            }
            $id = $p[0];
            $timestamp = $p[1];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            //получим блюдо по id
            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);

            $orderService = new OrderService($em);
            $order = $orderService->findOrder([
                'user' => $user,
                'date' => $date,
            ]);

            //создадим item для заказа и добавим его в заказ
            $orderItemService = new OrderItemService($em);
            $item = $orderItemService->findItem([
                'dish' => $dish,
                'order' => $order,
            ]);

            if(count($item) == 0)
            {
                $result = [
                    'response' => "no item",
                ];
                $vm = new JsonModel($result);
                return $vm;
            }

            $item = array_shift($item);
            if($item->getCount() == 0)
            {
                $result = [
                    'response' => "no count",
                ];
                $vm = new JsonModel($result);
                return $vm;
            }

            $item->setCount($item->getCount() -1);
            $orderItemService->save($item);
            if ($item->getCount() == 0)
                $orderItemService->delete($item);

            $result = [
                'response' => "ok",
            ];
            $vm = new JsonModel($result);
            return $vm;
        }
    }
}
