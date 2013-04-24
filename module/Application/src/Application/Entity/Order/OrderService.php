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
     * @return array
     */
    public function getAllOrder()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        return $repo->findAll();
    }

    /**
     * @param $id
     * @return object
     */
    public function findOrderById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        return $repo->find($id);
    }

    /**
     * @param $data
     * @return array
     */
    public function findOrder(\DateTime $date, ZfcUser $user = null)
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        $storage = $repo->findOneBy(['date' => $date]);

        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');

        if (is_null($user))
            $data = ['storage' => $storage];
        else
            $data = ['user' => $user, 'storage' => $storage];

        return $repo->findBy($data);
    }

    /**
     * @param null $data
     * @return Order
     */
    public function createOrder($data = null)
    {
        //найдем зранилище, если его нет то создадим
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        $storage = $repo->findOneBy(['date' => $data['date']]);

        if(!$storage)
        {
            $storageService = new OrderStorageService($this->_em);
            $storage = $storageService->createStorage([
                'date' => $data['date']
            ]);
        }

        $data['storage'] = $storage;
        $order = new Order($data);
        $this->save($order);

        return $order;
    }

    /**
     * @param OrderItem $item
     * @param Order $order
     * @return $this
     */
    public function addItemToOrder(OrderItem $item, Order $order)
    {
        $order->setItem($item);
        $this->save($order);

        return $this;
    }

    public function getTotal($date)
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        $storage = $repo->findOneBy(['date' => $date]);

        $orders = $storage->getOrder();

        $result = 0;
        foreach($orders as $order)
        {
            $result = $result + $order->getTotal();
        }
        return $result;
    }

    public function findItems($date)
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        $storage = $repo->findOneBy(['date' => $date]);

        $orders = $storage->getOrder();

        $result = [];
        $count = [];
        $cost = [];
        //получим все item по полученным заказам
        foreach($orders as $order)
        {
            $items = $order->getItem();
            foreach ($items as $item)
            {
                $nameItem = $item->getDish()->getName();
                $c = $item->getDish()->getCost();
                $key = array_search($nameItem, $result);
                if($key === false)
                {
                    $count[] = $item->getCount();
                    $result[] = $nameItem;
                    $cost[] = $c;
                } else {
                    $count[$key] = $count[$key] + $item->getCount();
                }
            }
        }

        $return = [];
        for($i = 0; $i < count($result); $i++)
        {
            $ret['dish'] = $result[$i];
            $ret['count'] = $count[$i];
            $ret['cost'] = $cost[$i];
            $return[] = $ret;
        }
        return $return;
    }

    public function closeOrders($date)
    {
        //получим все заказы за эту дату
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        $orders = $repo->findBy(['date' => $date]);

        foreach($orders as $order)
        {
            $order->setStatus('close');
            $this->save($order);
        }
    }

    public function openOrders($date)
    {
        //получим все заказы за эту дату
        $repo = $this->_em->getRepository('\Application\Entity\Order\Order');
        $orders = $repo->findBy(['date' => $date]);

        foreach($orders as $order)
        {
            $order->setStatus('open');
            $this->save($order);
        }
    }
}