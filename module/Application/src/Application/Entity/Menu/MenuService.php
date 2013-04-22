<?php
namespace Application\Entity\Menu;

use Doctrine\ORM\EntityRepository;
use Zend\ServiceManager\ServiceManager;
use \Exception;
use \DateTime;

class MenuService extends EntityRepository {

    protected $_em;

    public function __construct($em)
    {
        $this->_em = $em;
    }

    /**
     * Сохраним группу в базе
     *
     * @param Menu $menu
     * @param boolean $flush
     * @throws DatabaseException
     * @return Menu
     */
    public function save(Menu $menu, $flush = true)
    {
        try
        {
            $this->_em->persist($menu);

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
        return $menu;
    }

    /**
     * Удалим пункт меню из базы
     *
     * @param menu $menu
     * @param boolean $flush
     * @throws DatabaseException
     * @return menu
     */
    public function delete(Menu $menu, $flush = true)
    {
        try
        {
            $this->_em->remove($menu);
            if($flush)
                $this->_em->flush();
        }
        catch(\Exception $exception)
        {
            $message = $exception->getMessage();
            throw new Exception("Database error: $message");
        }

        //return on success
        return $menu;
    }

    /**
     * Получим всех пользователей
     *
     * @return array[Users]
     */
    public function getAllMenu()
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->findAll();
    }

    public function getMenuById($id)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->find($id);
    }

    public function getMenuByDate(DateTime $date)
    {
        $repo = $this->_em->getRepository('\Application\Entity\Menu\Menu');
        return $repo->findBy(['date' => $date]);
    }

    public function createMenu($data = null)
    {
        $menu = new Menu($data);
        $this->save($menu);

        return $menu;
    }

}