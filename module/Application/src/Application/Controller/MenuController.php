<?php

namespace Application\Controller;

use Application\Entity\Dish\Dish;
use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishGroup;
use Application\Entity\Dish\DishService;
use Application\Entity\Menu\Menu;
use Application\Entity\Menu\MenuService;
use Application\Entity\Order\OrderService;
use Application\Entity\Order\OrderItemService;
use Application\Entity\Price\Price;
use Application\Entity\Price\PriceService;
use Application\Entity\User\User;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use \DateTime;
use \DateTimeZone;

class MenuController extends AbstractActionController
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
        $vm->setTemplate('application/menu/index');

        return $vm;
    }

    public function dishAction()
    {
        $em = $this->getEntityManager();

        $user = $this->zfcUserAuthentication()->getIdentity();

        $dishService = new DishService($em);
        $dishGroupService = new DishGroupService($em);
        $menuService = new MenuService($em);
        $priceService = new PriceService($em);
        $orderService = new OrderService($em);
        $itemService = new OrderItemService($em);

        $date = new DateTime('now', new DateTimeZone('UTC'));


        //создадим 5 групп и в каждой группе 5 блюд
//        for($i = 0; $i < 5; $i++)
//        {
//            $group = $dishGroupService->createDishGroup([
//                'name' => 'Group ' . $i,
//            ]);
//
//            for($j = 0; $j < 5; $j++)
//            {
//                $name = 'Dish ' . $i . " - " . $j;
//                $dish = $dishService->createDish([
//                    'name' => $name,
//                    'group' => $group,
//                ]);
//
//                $iD = date('d', $date->getTimestamp());
//                $iM = date('m', $date->getTimestamp());
//                $iY = date('y', $date->getTimestamp());
//
//                $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));
//
//                $price = $priceService->createPrice([
//                    'cost' => mt_rand(10,100),
//                    'dish' => $dish,
//                    'date' => $date,
//                ]);
//
//                $menu = $menuService->createMenu([
//                    'date' => $date,
//                    'dish' => $dish,
//                ]);
//            }
//        }

        //создадим заказ
//        $order = $orderService->createOrder([
//            'user' => $user,
//            'date' => $date,
//        ]);
//
//        //создадим элементы заказа с блюдами 7, 12, 19 из меню
//        $menu = $menuService->findMenuById(7);
//        $item = $itemService->createItem([
//            'menu' => $menu,
//            'order' => $order,
//        ]);
//        $menu = $menuService->findMenuById(12);
//        $item = $itemService->createItem([
//            'menu' => $menu,
//            'order' => $order,
//        ]);
//        $menu = $menuService->findMenuById(19);
//        $item = $itemService->createItem([
//            'menu' => $menu,
//            'order' => $order,
//        ]);


        $dg = $dishGroupService->getAllDishGroup();

        $response = ['groups' => $dg];

        $vm = new ViewModel($response);
        $vm->setTemplate('application/menu/dish');

        return $vm;
    }

}
