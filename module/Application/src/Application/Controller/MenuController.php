<?php

namespace Application\Controller;

use Application\Entity\Dish\Dish;
use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishGroup;
use Application\Entity\Dish\DishService;
use Application\Entity\Menu\Menu;
use Application\Entity\Menu\MenuService;
use Application\Entity\Order\OrderService;
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

        $dishService = new DishService($em);
        $dishGroupService = new DishGroupService($em);
        $menuService = new MenuService($em);
        $priceService = new PriceService($em);
        $orderService = new OrderService($em);

        $dishs = $dishService->getAllDish();
        $dish = array_shift($dishs);

        $dateCur = new DateTime('now', new DateTimeZone('UTC'));

        $price = new Price();
        $price->setDish($dish);
        $price->setDate($dateCur);
        $price->setCost(160);

        $priceService->save($price);

        $menu = new Menu([
            'date' => $dateCur
        ]);

        $menu->setDish($dish);

        $menuService->save($menu);

        $dg = $dishGroupService->getAllDishGroup();

        $response = ['groups' => $dg];

        $vm = new ViewModel($response);
        $vm->setTemplate('application/menu/dish');

        return $vm;
    }

}
