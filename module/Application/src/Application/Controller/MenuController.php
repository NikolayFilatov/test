<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\Menu\MenuService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \DateTime;

class MenuController extends AbstractActionController
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

        $menuService = new MenuService($em);
        $menus = $menuService->getMenuByDate($dateNow);

        $response = [
            'dateNow' => $dateNow,
            'dates' => $dates,
            'menus' => $menus,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/menu/index');

        return $vm;
    }

    public function newMenuAction()
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

        $month = '';

        //Создадим массив недель
        //Определим дату понедельника этой недели
        $offsetDay = date("w", $timestamp) - 1;
        $offsetDay = $offsetDay == -1 ? 6 : $offsetDay;
        $date->sub(new \DateInterval('P' . $offsetDay . 'D'));

        //текущая дата в данном случае это дата понедельника текущей недели.
        $dateNow = clone $date;
        $dateRet = clone $date;

        //получим список недель для календаря
        //сместимся на 4 недели назад
        $date->sub(new \DateInterval('P4W'));
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
            $date->add(new \DateInterval('P1W'));
        }

        $dateNow1 = clone $dateNow;
        $dateNow1->add(new \DateInterval('P1W'));
        $str_dates = "(" . $dateNow->format("d.m.Y") . " - " . $dateNow1->format("d.m.Y") . ")";

        //получим меню на текущую неделю для knockout
        $menuService = new MenuService($em);

        $week_menu = $menuService->getMenuToWeek($dateNow);
        $dishGroupService = new DishGroupService($em);
        $groups = $dishGroupService->getAllDishGroup();

        $response = [
            'dateNow'   => $dateRet,
            'month'     => $month,
            'dates'     => $dates,
            'weekMenu'  => $week_menu,
            'groups'    => $groups,
            'str_dates' => $str_dates,
        ];
        $vm = new ViewModel($response);
        $vm->setTemplate('application/menu/new_menu');

        return $vm;
    }

}
