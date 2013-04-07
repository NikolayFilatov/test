<?php
namespace Application\Entity\User;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Chat\Chat;
use Application\Entity\Chat\ChatService;
use Application\Entity\Location\Location;
use Zend\ServiceManager\ServiceManager;
use \Exception;

class UserService extends EntityRepository {
	
	protected $_em;
	
	public function __construct($em)
	{
		$this->_em = $em;
	}

	/**
	 * Сохраним юзера в базе
	 * 
	 * @param User $user
	 * @param boolean $flush
	 * @throws DatabaseException
	 * @return ZfcUser
	 */
	public function save(ZfcUser $user, $flush = true)
	{
		try
		{
			$this->_em->persist($user);
	
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
		return $user;
	}
	
	/**
	 * Удалим юзера из базы
	 * 
	 * @param ZfcUser $user
	 * @param boolean $flush
	 * @throws DatabaseException
	 * @return ZfcUser
	 */
	public function delete(ZfcUser $user, $flush = true)
	{
		try
		{
			$this->_em->remove($user);
			if($flush)
				$this->_em->flush();
		}
		catch(\Exception $exception)
		{
			$message = $exception->getMessage();
			throw new Exception("Database error: $message");
		}
	
		//return on success
		return $user;
	}	
	
	/**
	 * Получим всех пользователей
	 * 
	 * @return array[Users]
	 */
	public function getAllUser()
	{
		$repo = $this->_em->getRepository('\Application\Entity\User\ZfcUser');
		return $repo->findAll();
	}
	
	/**
	 * Получим юзера по его id, если нет такого вернется Null
	 * 
	 * @param integer $id
	 * @return User
	 */
	public function getUserById($id)
	{
		$qb = $this->_em->createQueryBuilder();
		
		$qb->select('user')->from('Application\Entity\User\ZfcUser', 'user');
		$qb->andWhere('user.id = :userId');
		$qb->setParameter('userId', $id);
		
		$query = $qb->getQuery();
		$user = $query->getOneOrNullResult();
		
		return $user;
	}

	/**
	 * Получим сообщения стены юзера
	 *
	 * @param $user
	 * @param $order = 'DESC'
	 * @param $page = 1
	 * @param $perPage = 20
	 * @param $limit = 'all'
	 * @return User
	 */
	public function getWall(ZfcUser $user, $order = 'DESC', $page = 1, $perPage = 20, $limit = 'all')
	{
		$qb = $this->_em->createQueryBuilder();
	
		$qb->select('wall')->from('Application\Entity\Wall\UserWall', 'wall');
		$qb->andWhere('wall.user = :userId');
		$qb->setParameter('userId', $user->getId());
		$qb->addOrderBy('wall.id', $order);
		if($limit != 'all')
		{
			$qb->setFirstResult(($page * $perPage) - $perPage);
			$qb->setMaxResults($perPage);
		}
	
		$query = $qb->getQuery();
		$walls = $query->getResult();
	
		return $walls;
	}

}