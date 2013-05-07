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

    public function getDishesByGroupArray(
        DishGroup $group = null,
        $like = null,
        $limit = null)
    {
        $dql  = "SELECT dish.deleted, dish.name, dish.id id FROM Application\\Entity\\Dish\\Dish dish ";
        $dql .= "WHERE 1=1 ";
        if (!is_null($group))
            $dql .= " AND dish.group = " . $group->getId();
        if (!is_null($like))
            $dql .= " AND dish.name like '%" . $like . "%'";

        $query = $this->_em->createQuery($dql);

        $count = count($query->getArrayResult());

        if (!is_null($limit))
        {
            $query->setFirstResult(0);
            $query->setMaxResults($limit);
        }

        $result = $query->getArrayResult();
        $return = [
            'result' => $result,
            'count' => $count,
        ];

        return $return;
    }

}
