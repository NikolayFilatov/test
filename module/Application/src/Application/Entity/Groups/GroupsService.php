<?php
namespace Application\Entity\Groups;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Chat\Chat;
use Application\Entity\Chat\ChatService;
use Application\Entity\Location\Location;
use \Exception;

class GroupsService extends EntityRepository {
	
	protected $_em;
	
	public function __construct($em)
	{
		$this->_em = $em;
	}

	/**
	 * Сохраним юзера в базе
	 * 
	 * @param Groups $group
	 * @param boolean $flush
	 * @throws DatabaseException
	 * @return Groups
	 */
	public function save(Groups $group, $flush = true)
	{
		try
		{
			$this->_em->persist($group);
	
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
		return $group;
	}
	
	/**
	 * Удалим группу из базы
	 * 
	 * @param Groups $group
	 * @param boolean $flush
	 * @throws DatabaseException
	 * @return Groups
	 */
	public function delete(Groups $group, $flush = true)
	{
		try
		{
			$this->_em->remove($group);
			if($flush)
				$this->_em->flush();
		}
		catch(\Exception $exception)
		{
			$message = $exception->getMessage();
			throw new Exception("Database error: $message");
		}
	
		//return on success
		return $group;
	}

}