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
            $dat = explode("#", $data);
            foreach($ret as $r)
            {
                if(in_array($r->getGroup()->getId(), $dat))
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
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult('Application\Entity\Dish\Dish', 'd');
        $rsm->addFieldResult('d', 'id', 'id');
        $rsm->addFieldResult('d', 'name', 'name');
        $rsm->addJoinedEntityResult('Application\Entity\Price\Price', 'p', 'd', 'dish_id');
        $rsm->addFieldResult('p', 'dish_id', 'dish_id');
        $rsm->addFieldResult('p', 'cost', 'cost');

        $sql = 'SELECT d.id, d.name, p.cost  FROM dish d ' .
            'INNER JOIN price p ON d.id = p.dish_id where p.date=(select MAX(date) from price where dish_id = d.id)';
        $query = $this->_em->createNativeQuery($sql, $rsm);

        $price = $query->getArrayResult();

        echo "<pre>";
        var_dump($price);
        die();


        $result = [
            'dishes'  => $price,
        ];

        return $result;
    }

}
