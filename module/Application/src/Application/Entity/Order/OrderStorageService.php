<?php
namespace Application\Entity\Order;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use Zend\Stdlib\DateTime;

use Zend\Config\Config;
use Zend\Config\Writer\Ini;

class OrderStorageService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * @param Order $order
     * @param boolean $flush
     * @throws DatabaseException
     * @return OrderStorage
     */
    public function save(OrderStorage $storage, $flush = true)
    {
        try
        {
            $this->_em->persist($storage);

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
        return $storage;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param Order $order
     * @param boolean $flush
     * @throws DatabaseException
     * @return Order
     */
    public function delete(OrderStorage $storage, $flush = true)
    {
        try
        {
            $this->_em->remove($storage);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $storage;
    }

    /**
     * @return array
     */
    public function getAllStorage()
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        return $repo->findAll();
    }

    /**
     * @param $id
     * @return object
     */
    public function findStorageById($id)
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        return $repo->find($id);
    }

    /**
     * @param $data
     * @return array
     */
    public function findStorage($data)
    {
        $repo = $this->_em
            ->getRepository('\Application\Entity\Order\OrderStorage');
        return $repo->findBy($data);
    }

    /**
     * @param null $data
     * @return Order
     */
    public function createStorage($data = null)
    {
        $storage = new OrderStorage($data);
        $this->save($storage);

        return $storage;
    }

    /**
     * @param Order $order
     * @param OrderStorage $storage
     * @return $this
     */
    public function addOrderToStorage(Order $order, OrderStorage $storage)
    {
        $storage->setItem($order);
        $this->save($storage);

        return $this;
    }

    public function closeStorage(OrderStorage $storage)
    {
        $storage->setStatus('close');
        $this->save($storage);

        return $storage;
    }

    public function openStorage(OrderStorage $storage)
    {
        $storage->setStatus('open');
        $this->save($storage);

        return $storage;
    }

    public function getFile($date)
    {
        $orderService = new OrderService($this->_em);
        $items = $orderService->findItems($date);

        if(!$items)
            return;

        $writer = new Ini();
        $config = new Config([], true);
        $total_count = 0;
        $total = 0;
        $total_pos = 0;
        foreach($items as $item)
        {
            $conf = new Config([], true);
            $conf->количество = $item['count'];
            $conf->стоимость = $item['cost'];
            $conf->сумма = $item['count'] * $item['cost'];

            $total_count += $item['count'];
            $total += $item['count'] * $item['cost'];
            $total_pos++;

            $name = str_replace(" ", "_", $item['dish']);

            $config->$name = $conf;
        }

        $conf = new Config([], true);
        $conf->Сумма = $total;
        $conf->Количество_блюд = $total_count;
        $conf->Количество_позиций = $total_pos;
        $config->Итого = $conf;

        $writer->toFile("public/orders/order_" . $date->format('d.m.Y') . ".ini", $config);

        return "order_" . $date->format('d.m.Y') . ".ini";
    }

}