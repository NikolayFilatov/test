<?php
namespace Application\Entity\OrderItem;

use Application\Entity\User\ZfcUser;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use Zend\Stdlib\DateTime;

class OrderItemService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * @param OrderItem $orderItem
     * @param boolean $flush
     * @throws DatabaseException
     * @return OrderItem
     */
    public function save(OrderItem $orderItem, $flush = true)
    {
        try
        {
            $this->_em->persist($orderItem);

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
        return $orderItem;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param OrderItem $orderItem
     * @param boolean $flush
     * @throws DatabaseException
     * @return OrderItem
     */
    public function delete(OrderItem $orderItem, $flush = true)
    {
        try
        {
            $this->_em->remove($orderItem);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $orderItem;
    }

    public function findOrderItemById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\OrderItem\OrderItem');
        return $repo->find($id);
    }
}