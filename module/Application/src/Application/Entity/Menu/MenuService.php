<?php
namespace Application\Entity\Menu;

use Application\Entity\Dish\Dish;
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

    public function getMenuByDishDate(Dish $dish, DateTime $date)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->findBy(['date' => $date, 'dish' => $dish]);
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

            $offsetDay = date("w", $date->getTimestamp());
//            $offsetDay = $offsetDay == -1 ? 6 : $offsetDay;

            $menu_day[$offsetDay] = $arr;
            $date->add(new \DateInterval('P1D'));
        }

        //приведем массив к виду
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
                    $return[$groupName][$name][$date] = [
                        'cost'      => $cost,
                        'in_menu'   => true,
                        'id'        => $id_menu,
                        'day'       => $date,
                    ];
                } else {
                    $return[$groupName][$name][$date] = [
                        'cost'      => $cost,
                        'in_menu'   => false,
                        'id'        => $id_menu,
                        'day'       => $date,
                    ];
                }
            }
        }

        $rrr = []; $iii = 0;
        foreach ($return as $kkk => $vvv)
        {
            $rr = [];
            $rrr[$iii] = [];
            foreach($vvv as $kk => $vv)
            {
                $r = [];
                $i = 1;
                $d1 = false; $d2 = false; $d3 = false; $d4 = false;
                $d5 = false; $d6 = false; $d7 = false;
                $id1 = 0; $id2 = 0; $id3 = 0; $id4 = 0;
                $id5 = 0; $id6 = 0; $id7 = 0;
                foreach($vv as $k => $v)
                {
                    $param = 'd' . $v['day'];
                    $paramId = 'id' . $v['day'];
                    $$param = $v['in_menu'];
                    $cost = $v['cost'];
                    $$paramId = $v['id'];

                    $i++;
                }

                $rr[] = [
                    'key'   => $kk,
                    'val'   => $r,
                    'cost'  => $cost,
                    'd1'    => $d1,
                    'd2'    => $d2,
                    'd3'    => $d3,
                    'd4'    => $d4,
                    'd5'    => $d5,
                    'd6'    => $d6,
                    'd7'    => $d7,
                    'id1'    => $id1,
                    'id2'    => $id2,
                    'id3'    => $id3,
                    'id4'    => $id4,
                    'id5'    => $id5,
                    'id6'    => $id6,
                    'id7'    => $id7,
                ];
            }
            $rrr[$iii] = [
                'key' => $kkk,
                'val' => $rr,
            ];
            $iii++;
        }

        return $rrr;
//        return $menu_day;
    }
}