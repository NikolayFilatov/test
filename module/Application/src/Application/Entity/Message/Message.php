<?php
namespace Application\Entity\Message;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="Messages")
*/

class Message extends Entity {
	
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
	 * @ORM\Column(type="string", length=1024)
	 * @var string
	 */
	protected $message;
	
	/**
	 * Хозяин
	 * 
     * @ORM\Column(type = "integer")
     * @var integer
	 */
	protected $owner;
	
	
    /**
     * Construct
     * Instantiates user entity.
     *
     * @return void
     */
    public function __construct($data = null)
    {
    	return parent::__construct($data);
    }
    
    public function toArray()
    {
    	
    }

}