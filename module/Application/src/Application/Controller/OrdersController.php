<?php

namespace Application\Controller;

use Application\Entity\Order\Order;
use Application\Entity\Order\OrderService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

        $orders = $orderService->getAllOrder();
        foreach($orders as $order)
        {
            $item = $order->getItem();
            foreach($item as $i)
            {
                echo "1";
            }
            echo "<br>";
            //echo $total;
        }



        die();

        $date = new DateTime('now', new DateTimeZone('UTC'));
        $date = $this->DateFormat()->getDay($date);

        $orders = $orderService->findOrder([
            //'date' => $date,
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
