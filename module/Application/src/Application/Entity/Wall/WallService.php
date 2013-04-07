<?php
namespace Application\Entity\Wall;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Chat\Chat;
use Application\Entity\Chat\ChatService;
use Application\Entity\Location\Location;
use Zend\ServiceManager\ServiceManager;
use \Exception;

class WallService extends EntityRepository {
	
	protected $_em;
	
	public function __construct($em)
	{
		$this->_em = $em;
	}

	/**
	 */
	public function save($wall, $flush = true)
	{
		try
		{
			$this->_em->persist($wall);
	
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
		return $wall;
	}
	
	/**
	 */
	public function delete($wall, $flush = true)
	{
		try
		{
			$this->_em->remove($wall);
			if($flush)
				$this->_em->flush();
		}
		catch(\Exception $exception)
		{
			$message = $exception->getMessage();
			throw new Exception("Database error: $message");
		}
	
		//return on success
		return $wall;
	}
	
	/**
	 */
	public function getWallById($id, $class = 'Application\Entity\Wall\UserWall')
	{
		$qb = $this->_em->createQueryBuilder();
		
		$qb->select('wall')->from($class, 'wall');
		$qb->andWhere('wall.id = :wallId');
		$qb->setParameter('wallId', $id);
		
		$query = $qb->getQuery();
		$wall = $query->getOneOrNullResult();
		
		return $wall;
	}
	
	/**
	 */
	public function getWallCommentById($id, $class = 'Application\Entity\Wall\UserWallComment')
	{
		$qb = $this->_em->createQueryBuilder();
		
		$qb->select('comment')->from($class, 'comment');
		$qb->andWhere('comment.id = :commentId');
		$qb->setParameter('commentId', $id);
	
		$query = $qb->getQuery();
		$comment = $query->getOneOrNullResult();

		return $comment;
	}

}
