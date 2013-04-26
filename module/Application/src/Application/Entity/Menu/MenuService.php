<?php
namespace Application\Entity\Menu;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use \DateTime;

class MenuService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * Сохраним группу в базе
     *
     * @param Menu $menu
     * @param boolean $flush
     * @throws DatabaseException
     * @return Menu
     */
    public function save(Menu $menu, $flush = true)
    {
        try
        {
            $this->_em->persist($menu);

            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = "Database error: " . $exception->getMessage();
            var_dump($message);
            die();
            throw new Exception($message);
        }

        //return on success
        return $menu;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param menu $menu
     * @param boolean $flush
     * @throws DatabaseException
     * @return menu
     */
    public function delete(Menu $menu, $flush = true)
    {
        try
        {
            $this->_em->remove($menu);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $menu;
    }

    /**
     * Получим всех пользователей
     *
     * @return array[Users]
     */
    public function getAllMenu()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->findAll();
    }

    public function getMenuById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->find($id);
    }

    public function createMenu($data = null)
    {
        $menu = new Menu($data);
        $this->save($menu);

        return $menu;
    }

    public function getMenuByDate(DateTime $date)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->findBy(['date' => $date]);
    }

    /**
     * @param DateTime $date
     * @return array
     */
    public function getMenuToWeek(DateTime $date)
    {
        //Определим дату понедельника этой недели
        $offsetDay = date("w", $date->getTimestamp()) - 1;
        $offsetDay = $offsetDay == -1 ? 6 : $offsetDay;
        $date->sub(new \DateInterval('P' . $offsetDay . 'D'));

        $menu_day = []; //меню на каждый день недели
        for($i = 1; $i <= 7; $i++)
        {
            //получим массив сущностей пунктов меню
            $dm = $this->getMenuByDate($date);

            $arr = [];
            foreach($dm as $m)
            {
                $arr[] = $m->toArray();
            }

            $menu_day[$date->format('d.m.Y')] = $arr;
            $date->add(new \DateInterval('P1D'));
        }

        //приведем массив к виду
        // group -- name-cost-1-1-0-0-1-0-0
        //          name-cost-1-0-1-0-1-0-0

        $return = [];
        foreach($menu_day as $key => $val)
        {
            $arrDate = [];
            foreach($val as $m)
            {
                $id_menu = $m['id'];
                $dish = $m['dish'];
                $name = $dish['name'];
                $groupName = $dish['groupName'];
                $cost = $dish['cost'];

                $date = $key;

                if($m['deleted'] == 0){

//                    $vv = [
//                        'cost'  => $cost,
//                        'id'    => $id_menu,
//                    ];
//
//                    $dd = [
//                        'date' => $date,
//                        'value' => $vv,
//                    ];
//
//                    $nn = [
//                        'name' => $name,
//                        'date' => $dd,
//                    ];
//
//                    $ret = [
//                        'groupName' => $groupName,
//                        'dish' => $nn,
//                    ];
//
//                    $return[] = $ret;
                    $return[$groupName][$name][$date] = [
                        'cost'  => $cost,
                        'id'    => $id_menu,
                    ];
                } else {
                    $return[$groupName][$name][$date] = [
                        'cost'  => 0,
                        'id'    => $id_menu,
                    ];
                }
            }
        }

        $rrr = [];
        foreach ($return as $kkk => $vvv)
        {
            $rr = [];
            foreach($vvv as $kk => $vv)
            {
                $r = [];
                foreach($vv as $k => $v)
                {
                    $r[] = [
                        'date'  => $k,
                        'cost'  => $v['cost'],
                        'id'    => $v['id'],
                    ];
                    $cost = $v['cost'];
                }
                $rr[] = [
                    'key'   => $kk,
                    'val'   => $r,
                    'cost'  => $cost,
                ];
            }
            $rrr[] = [
                'key' => $kkk,
                'val' => $rr,
            ];
        }

        return $rrr;
    }
}