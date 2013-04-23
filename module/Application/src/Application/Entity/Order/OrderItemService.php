<?php
namespace Application\Entity\Order;

use Application\Entity\Order\OrderItem;
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

    public function getItemById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\OrderItem');
        return $repo->find($id);
    }

    /**
     * @param $data
     * @return array
     */
    public function findItem($data)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\OrderItem');
        return $repo->findBy($data);
    }

    public function createItem($data = null)
    {
        //ищем в заказе такое блюдо
        $repo = $this->_em->getRepository('\Application\Entity\Order\OrderItem');
        $item = $repo->findOneBy([
            'order' => $data['order'],
            'dish' => $data['dish'],
        ]);

        if($item)   //в заказе такое блюдо уже есть, увеличим кол-во
        {
            $item->setCount($item->getCount() + 1);
            $this->save($item);
        } else      //в заказе такого блюда нет, создадим item
        {
            $item = new OrderItem($data);
            $this->save($item);
        }

        return $item;
    }
}