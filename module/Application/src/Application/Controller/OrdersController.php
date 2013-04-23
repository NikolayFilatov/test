<?php

namespace Application\Controller;

use Application\Entity\Order\OrderService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use \DateTime;

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

        $timestamp =  $this->getEvent()->getRouteMatch()->getParam('timestamp');
        if (!isset($timestamp))
        {
            $date = new DateTime('now');
            $timestamp = $date->getTimestamp();
        }

        $date = new DateTime('now');
        $date->setTimestamp($timestamp);
        $date = $this->DateFormat()->getDay($date);

        $dateNow = clone $date;

        //Создадим массив календаря +/- 7 дней от переданной даты
        $date->sub(new \DateInterval('P4D'));
        for($i = 0; $i < 9; $i++)
        {
            $d = $date->format('d.m.y');
            $t = $date->getTimestamp();
            $class = 'button1';
            if ($i == 4)
                $class = "button11";
            $dates[] = [
                'date' => $d,
                'timestamp' => $t,
                'class' => $class,
            ];

            $date->add(new \DateInterval('P1D'));
        }

        $orderService = new OrderService($em);
        $orders = $orderService->findOrder([
            'date' => $dateNow,
        ]);

        $response = [
            'orders' => $orders,
            'dates' => $dates,
            'dateNow' => $dateNow,

        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/orders/index');

        return $vm;
    }

}
