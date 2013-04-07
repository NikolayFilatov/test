<?php
namespace Application\Entity\Wall;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;
use \DateTime;
use \DateTimeZone;

/**
* @ORM\Entity
* @ORM\Table(name="user_wall_comments")
*/

class UserWallComment extends Entity {
	
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\Wall\UserWall")
     * @var \Application\Entity\Wall\UserWall
	 */
	protected $wall;
	
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

}