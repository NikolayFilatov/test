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

class OrdersController extends AbstractActionController
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

        $orderService = new OrderService($em);

        $date = new DateTime('now', new DateTimeZone('UTC'));
        $date = $this->DateFormat()->getDay($date);

        $orders = $orderService->findOrder([
            'date' => $date,
            'user' => $user,
        ]);

        $response = [
            'orders' => $orders,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/orders/index');

        return $vm;
    }

}
