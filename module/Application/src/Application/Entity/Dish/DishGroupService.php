<?php
namespace Application\Entity\Dish;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;

class DishGroupService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * Сохраним группу в базе
     *
     * @param Dish $dish
     * @param boolean $flush
     * @throws DatabaseException
     * @return Dish
     */
    public function save(DishGroup $dish, $flush = true)
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
     * Удалим группу из базы
     *
     * @param Dish $dish
     * @param boolean $flush
     * @throws DatabaseException
     * @return Dish
     */
    public function delete(DishGroup $dish, $flush = true)
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
     * @return array[Users]
     */
    public function getAllDishGroup()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Dish\DishGroup');
        return $repo->findAll();
    }

    public function getGroupById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Dish\DishGroup');
        return $repo->find($id);
    }

    public function createDishGroup($data = null)
    {
        $group = new DishGroup($data);
        $this->save($group);

        return $group;
    }

}