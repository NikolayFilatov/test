<?php
namespace Application\Entity\Dish;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use Doctrine\ORM\Query\ResultSetMapping;

class DishService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * Сохраним блюдо в базе
     *
     * @param Dish $dish
     * @param boolean $flush
     * @throws DatabaseException
     * @return Dish
     */
    public function save(Dish $dish, $flush = true)
    {
        try
        {
            $this->_em->persist($dish);

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
        return $dish;
    }

    /**
     * Удалим блюдо из базы
     *
     * @param Dish $dish
     * @param boolean $flush
     * @throws DatabaseException
     * @return Dish
     */
    public function delete(Dish $dish, $flush = true)
    {
        try
        {
            $this->_em->remove($dish);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $dish;
    }

    /**
     * Получим всех пользователей
     *
     * @param $data (string, separator = "#")
     * @param $like string
     * @return array[Users]
     */
    public function getAllDish($data = '', $like = '')
    {
        $repo = $this->_em->getRepository('\Application\Entity\Dish\Dish');
        $ret = $repo->findAll();
        $return = [];

        if($data != '')
        {
            foreach($ret as $r)
            {
                if($r->getGroup()->getId() == $data)
                    $return[] = $r;
            }
        }
//        else
//        {
//            $return = $ret;
//        }

        if($like != '')
        {
            $ret = $return;
            $return = [];
            foreach ($ret as $r)
            {
                $pos = stripos($r->getName(), $like);
                if ($pos !== false)
                    $return[] = $r;
            }
        }

        return $return;
    }

    public function createDish($data = null)
    {
        $dish = new Dish($data);
        $this->save($dish);

        return $dish;
    }

    public function getDishById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Dish\Dish');
        return $repo->find($id);
    }

    public function getDishesByGroup(DishGroup $group)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Dish\Dish');
        return $repo->findBy(['group' => $group]);
    }

    public function getDishesByGroupArray(DishGroup $group)
    {

        $dql  = "SELECT dish.deleted, dish.name, dish.id id, price.cost, price.id pid FROM Application\\Entity\\Dish\\Dish dish ";
        $dql .= "LEFT JOIN Application\\Entity\\Price\\Price price WITH price.dish = dish.id ";
//        $dql .= "AND price.date=(SELECT MAX(price2.date) FROM Application\\Entity\\Price\\Price price2 WHERE price2.dish = dish.id GROUP BY price2.dish) ";
        $dql .= "WHERE dish.group = " . $group->getId();

        $query = $this->_em->createQuery($dql);

        $results = $query->getArrayResult();

        $return = [];
        foreach($results as $r)
        {
            if(isset($return[$r['id']]))
            {
                if($return[$r['id']]['pid'] < $r['pid'])
                    $return[$r['id']] = $r;
            } else {
                $return[$r['id']] = $r;
            }
        }

        return $return;
    }

}
