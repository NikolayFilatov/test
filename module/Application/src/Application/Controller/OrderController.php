<?php

namespace Application\Controller;

use Application\Entity\Menu\MenuService;
use Application\Entity\Order\OrderService;
use Application\Entity\Order\OrderStorageService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \DateTime;


class OrderController extends AbstractActionController
{
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em)
        {
            $this->em = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        $em = $this->getEntityManager();

        $user = $this->zfcUserAuthentication()->getIdentity();

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
        $order = $orderService->findOrder($dateNow, $user);
        if(count($order) > 0)
            $order = array_shift($order);

        $menuService = new MenuService($em);
        $menus = $menuService->getMenuByDate($dateNow);

        $response = [
            'dateNow' => $dateNow,
            'dates' => $dates,
            'menus' => $menus,
            'order' => $order,
            'class' => $class,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/order/index');

        return $vm;
    }

    public function testAction()
    {

    }

}
