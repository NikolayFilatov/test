<?php
namespace Application\Entity\Order;

use Application\Entity\User\ZfcUser;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use Zend\Stdlib\DateTime;

class OrderService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * @param Order $order
     * @param boolean $flush
     * @throws DatabaseException
     * @return Order
     */
    public function save(Order $order, $flush = true)
    {
        try
        {
            $this->_em->persist($order);

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
        return $order;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param Order $order
     * @param boolean $flush
     * @throws DatabaseException
     * @return Order
     */
    public function delete(Order $order, $flush = true)
    {
        try
        {
            $this->_em->remove($order);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $order;
    }

    /**
     * Получим всех пользователей
     *
     * @return array[Users]
     */
    public function getAllOrder()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        return $repo->findAll();
    }

    public function findOrderById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        return $repo->find($id);
    }

    public function getOrderByUser(ZfcUser $user)
    {
        return null;
    }

    public function getOrderByDate(DateTime $date)
    {

        return null;
    }

}