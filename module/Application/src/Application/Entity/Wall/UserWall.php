<?php
namespace Application\Entity\Wall;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;
use \DateTimeZone;

/**
* @ORM\Entity
* @ORM\Table(name="user_walls")
*/

class UserWall extends Entity {
	
	protected $protectedProperties = [
		'id',
	];
	

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	protected $id;
	
	/**
	 * Хозяин
	 * 
     * @ORM\ManyToOne(targetEntity="Application\Entity\User\ZfcUser")
     * @var \Application\Entity\User\ZfcUser
	 */
	protected $user;
	
	/**
	 * Сообщение
	 * 
     * @ORM\Column(type = "string", length=1024)
     * @var string
	 */
	protected $message;
	
	/**
	 * Автор сообщения
	 * 
     * @ORM\ManyToOne(targetEntity="Application\Entity\User\ZfcUser")
     * @var \Application\Entity\User\ZfcUser
	 */
	protected $autor;
	
	/**
	 * Wall creation date
	 *
	 * @ORM\Column(type = "datetime")
	 * @var \DateTime
	 */
	protected $created;
	
	/**
	 * Comments
	 * 
     * @ORM\OneToMany(
     * 		targetEntity="Application\Entity\Wall\UserWallComment",
     * 		mappedBy="wall",
     * 		cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\Collection
	 */
	protected $comments;
	
    /**
     * Construct
     * Instantiates user entity.
     *
     * @return void
     */
    public function __construct($data = null)
    {
    	$this->created = new DateTime('now', new DateTimeZone('UTC'));
    	return parent::__construct($data);
    }
    
    public function toArray()
    {
    	
    }
    
    public function addComment(UserWallComment $comment){
    	$this->comments->add($comment);
    	$comment->setWall($this);
    }

}