<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishService;
use Application\Entity\Menu\MenuService;
use Application\Entity\Order\OrderItemService;
use Application\Entity\Order\OrderService;
use Application\Entity\Order\OrderStorageService;
use Application\Entity\Price\PriceService;
use Application\Entity\User\ZfcUser;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;

use Zend\View\Model\JsonModel;
use DateTime;
use DateInterval;

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

            $param = $this->getRequest()->getPost();
			$id = $param['id'];
            $data = $param['data'];
            $type = $param['type'];

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

            $result = ['response' => 'ok'];
            return new JsonModel($result);
		}  	
    }

    public function removeDishAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);
            $dish->markDelete();
            $dishService->save($dish);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function restoreDishAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);
            $dish->markUnDelete();
            $dishService->save($dish);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function removeDishGroupAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            $dishGroupService = new DishGroupService($em);
            $group = $dishGroupService->getGroupById($id);
            $dishGroupService->delete($group);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function addDishGroupAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $name = $param['name'];

            $groupService = new DishGroupService($em);
            $groupService->createDishGroup(['name' => $name]);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function addDishAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            $groupService = new DishGroupService($em);
            $group = $groupService->getGroupById($id);

            $dishService = new DishService($em);
            $dishService->createDish([
                'name' => 'Новое блюдо',
                'group' => $group
            ]);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function createMenuCatalogAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $timestamp = $param['timestamp'];

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
                $dishes = $group->getDish();
                foreach($dishes as $dish)
                {
                    if (!$dish->isDeleted())
                        $menuService->createMenu([
                            'date' => $date,
                            'dish' => $dish,
                        ]);
                }
            }

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function excludeMenuAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            //исключим из меню на заданную дату пункт с id
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            $menu->markDelete();
            $menuService->save($menu);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function includeMenuAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];

            //исключим из меню на заданную дату пункт с id
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            $menu->markUnDelete();
            $menuService->save($menu);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function addItemToOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];
            $timestamp = $param['date'];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            //ищем заказ этого юзера на эту дату.
            $orderService = new OrderService($em);
            $order = $orderService->findOrder($date, $user);

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

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function removeItemFromOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getPost();
            $id = $param['id'];
            $timestamp = $param['date'];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            //получим блюдо по id
            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);

            $orderService = new OrderService($em);
            $order = $orderService->findOrder($date, $user);

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

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function updateUserColorAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getPost();
            $hex = $param['hex'];

            $user->setColor($hex);
            $userService = new UserService($em);
            $userService->save($user);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function updateUserBackAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getPost();
            $hex = $param['hex'];

            $user->setBackcolor($hex);
            $userService = new UserService($em);
            $userService->save($user);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function updateUserNameAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $user = $this->zfcUserAuthentication()->getIdentity();

            $param = $this->getRequest()->getPost();
            $name = $param['name'];

            $user->setUsername($name);
            $userService = new UserService($em);
            $userService->save($user);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function closeOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $timestamp = $param['date'];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $storageService = new OrderStorageService($em);
            $storage = $storageService->findStorage([
                'date' => $date
            ]);
            if ($storage)
                $storageService->closeStorage($storage[0]);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function openOrderAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $timestamp = $param['date'];

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $storageService = new OrderStorageService($em);
            $storage = $storageService->findStorage([
                'date' => $date
            ]);
            if($storage)
                $storageService->openStorage($storage[0]);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function getXmlAction()
    {
        if($this->getRequest()->isPost())
        {
            $em = $this->getEntityManager();

            $param = $this->getRequest()->getPost();
            $date = $param['date'];

            $storageService = new OrderStorageService($em);
            $storageService->getXml($date);

            $result = ['response' => 'ok'];
            return new JsonModel($result);
        }
    }

    public function getAjaxMenuAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $d = $date->format('d.m.Y');

            $menuService = new MenuService($em);
            $menu = $menuService->getMenuToWeek($date);

            $result = [
                'menu'      => $menu,
                'test'      => $d,
            ];

            return new JsonModel($result);
        }
    }

    public function removeItemMenuAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $id = $this->getRequest()->getQuery()->id;
            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $date2 = clone $date;

            //удалим пункт меню
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            $dish = $menu->getDish();

            for($i = 0; $i < 7; $i++)
            {
                $menus = $menuService->getMenuByDishDate($dish, $date2);
                foreach($menus as $menu)
                {
                    $menuService->delete($menu);
                }
                $date2->add(new DateInterval('P1D'));
            }

            $menu = $menuService->getMenuToWeek($date);

            $result = [
                'menu'      => $menu,
            ];

            return new JsonModel($result);
        }
    }

    public function changeItemByIdAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $id = $this->getRequest()->getQuery()->id;
            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            //удалим пункт меню
            $menuService = new MenuService($em);
            $menu = $menuService->getMenuById($id);
            if($menu->isDeleted())
                $menu->markUnDelete();
            else
                $menu->markDelete();

            $menuService->save($menu);

            $menu = $menuService->getMenuToWeek($date);

            $result = [
                'menu'      => $menu,
            ];
            return new JsonModel($result);
        }
    }

    public function getAjaxListAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $groups = $this->getRequest()->getQuery()->groups;
            $like = $this->getRequest()->getQuery()->like;

//            $groupService = new DishGroupService($em);
//            $group = $groupService->getGroupById($groups);

            $dishService = new DishService($em);

            if ($groups == '' && $like == '')
                $dishes = [];
            else
                $dishes = $dishService->getAllDish($groups, $like);
//                $dishes = $dishService->getDishesByGroupArray($group);

            $return = [];
            foreach($dishes as $dish)
            {
                if($dish->isDeleted() == 0)
                {
                    $ret['name'] = $dish->getName();
                    $ret['id'] = $dish->getId();
                    $return[] = $ret;
                }
            }

            return new JsonModel($return);
//            return new JsonModel($dishes);
        }
    }

    public function addItemToMenuAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $id = $this->getRequest()->getQuery()->id;
            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $date2 = clone $date;

            $menuService = new MenuService($em);
            $dishService = new DishService($em);
            $dish = $dishService->getDishById($id);

            //проверить нет ли такого блюда уже в меню
            $m = $menuService->getMenuByDishDate($dish, $date);
            if (!$m)
                for($i = 0; $i < 7; $i++)
                {
                    $deleted = 0;
                    if ($i > 4)
                        $deleted = 1;

                    $menuService->createMenu([
                        'date'      => $date2,
                        'dish'      => $dish,
                        'dishGroup' => $dish->getGroup()->getId(),
                        'deleted'   => $deleted,
                    ]);
                    $date2->add(new DateInterval('P1D'));
                }

            $menu = $menuService->getMenuToWeek($date);

            $result = [
                'menu'      => $menu,
            ];
            return new JsonModel($result);
        }
    }

    public function addGroupItemToMenuAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $arr_id = $this->getRequest()->getQuery()->arr_id;
            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $date2 = clone $date;

            $menuService = new MenuService($em);
            $dishService = new DishService($em);

            //переберем массив id блюд, получим по ним блюда и добавим в меню
            foreach ($arr_id as $id)
            {
                $dish = $dishService->getDishById($id['id']);

                //проверить нет ли такого блюда уже в меню
                $m = $menuService->getMenuByDishDate($dish, $date);
                if (!$m)
                {
                    for($i = 0; $i < 7; $i++)
                    {
                        $deleted = 0;
                        if ($i > 4)
                            $deleted = 1;

                        $menuService->createMenu([
                            'date'      => $date2,
                            'dish'      => $dish,
                            'dishGroup' => $dish->getGroup()->getId(),
                            'deleted'   => $deleted,
                        ]);
                        $date2->add(new DateInterval('P1D'));
                    }
                    $date2->sub(new DateInterval('P7D'));
                }
            }

            $menu = $menuService->getMenuToWeek($date);

            $result = [
                'menu'      => $menu,
            ];
            return new JsonModel($result);
        }
    }

    public function removeAllItemFromMenuAction()
    {
        if($this->getRequest()->isGet())
        {
            $em = $this->getEntityManager();

            $timestamp = $this->getRequest()->getQuery()->date;

            $date = new \DateTime('now');
            $date->setTimestamp($timestamp);

            $menuService = new MenuService($em);

            for($i = 0; $i < 7; $i++)
            {
                $menus = $menuService->getMenuByDate($date);
                foreach($menus as $m)
                {
                    $menuService->delete($m);
                }
                $date->add(new DateInterval('P1D'));
            }

            $result = [
                'menu'      => [],
            ];
            return new JsonModel($result);
        }
    }
}
