<?php

namespace Application\Controller;

use Application\Entity\Order\OrderService;
use Application\Entity\Order\OrderStorageService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use \DateTime;

use Zend\Config\Config;
use Zend\Config\Writer\Ini;


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
        $this->redirect()->toRoute('allorder/dish');
    }

    public function userAction()
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


        $storageService = new OrderStorageService($em);
        $storage = $storageService->findStorage([
            'date' => $dateNow,
        ]);

        $class = "li_group";
        if($storage)
        {
            $storage = array_shift($storage);
            $class = $storage->getStatus() ==
                "close" ? "li_group_close" : "li_group";
        }

        $orderService = new OrderService($em);
        $orders = $orderService->findOrder($dateNow);

        $total = $orderService->getTotal($dateNow);

        $response = [
            'orders' => $orders,
            'dates' => $dates,
            'dateNow' => $dateNow,
            'total' => $total,
            'class' => $class,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/orders/user');

        return $vm;
    }

    public function dishAction()
    {
        $em = $this->getEntityManager();

        $timestamp =  $this->getEvent()->getRouteMatch()->getParam('timestamp');

        $date = new DateTime('now');
        if (!isset($timestamp))
            $timestamp = $date->getTimestamp();

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
        $storageService = new OrderStorageService($em);
        $storage = $storageService->findStorage([
            'date' => $dateNow,
        ]);

        $class = "li_group";
        if($storage)
        {
            $storage = array_shift($storage);
            $class = $storage->getStatus() ==
                "close" ? "li_group_close" : "li_group";
        }

        $total = 0;
        $items = [];
        $items = $orderService->findItems($dateNow);
        $total = $orderService->getTotal($dateNow);

        $response = [
            'items' => $items,
            'dates' => $dates,
            'dateNow' => $dateNow,
            'total' => $total,
            'class' => $class,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/orders/dish');

        return $vm;
    }

    public function getFileAction()
    {
        $em = $this->getEntityManager();

        $timestamp =  $this->getEvent()->getRouteMatch()->getParam('timestamp');

        $date = new DateTime('now');
        if (!isset($timestamp))
            $timestamp = $date->getTimestamp();

        $date->setTimestamp($timestamp);
        $date = $this->DateFormat()->getDay($date);

        $storageService = new OrderStorageService($em);
        $file = $storageService->getFile($date);


        $vm = new ViewModel(['file' => $file]);
        $vm->setTemplate('application/orders/xml_order');

        return $vm;
    }
}
