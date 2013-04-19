<?php
namespace Application\Entity\Price;

use Application\Entity\Dish\Dish;
use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use Zend\Stdlib\DateTime;

class PriceService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * @param Price $price
     * @param boolean $flush
     * @throws DatabaseException
     * @return Price
     */
    public function save(Price $price, $flush = true)
    {
        try
        {
            $this->_em->persist($price);

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
        return $price;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param Price $Price
     * @param boolean $flush
     * @throws DatabaseException
     * @return Price
     */
    public function delete(Price $price, $flush = true)
    {
        try
        {
            $this->_em->remove($price);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $price;
    }

    /**
     * Получим всех пользователей
     *
     * @return array[Users]
     */
    public function getAllPrice()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Price\Price');
        return $repo->findAll();
    }

    public function getPriceById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Price\Price');
        return $repo->find($id);
    }

    public function getPriceByDate(DateTime $date)
    {
        return null;
    }

    public function createPrice(Dish $dish, $cost, $date)
    {
        if ($dish->getCost() == $cost)
            return;

        $dateLast = 0;
        if ($dish->getLastDatePrice() != 0)
            $dateLast = $dish->getLastDatePrice()->format('d.m.Y H:i:s');

        if ($dateLast == $date->format('d.m.Y H:i:s'))
        {
            $price = $dish->getPrice()->last();
            $price->setCost($cost);
            $this->save($price);

            return;
        }

        $price = new Price([
            'dish' => $dish,
            'cost' => $cost,
            'date' => $date,
        ]);

        $this->save($price);

        return $price;
    }


}