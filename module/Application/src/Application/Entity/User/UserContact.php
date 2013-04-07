<?php
namespace Application\Entity\User;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="user_contacts")
*/

class UserContact extends Entity {
	
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
	 * @ORM\Column(type="string", length=255)
	 * @var string
	 */
	protected $value;
	
	/**
	 * @ORM\Column(type="string", length=10)
	 * @var string
	 */
	protected $type;
	
    /**
     * Пользователь
     * 
     * @ORM\ManyToOne(targetEntity="Application\Entity\User\ZfcUser")
     * @var \Application\Entity\User\ZfcUser
     */
    protected $user;
	
	
	
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