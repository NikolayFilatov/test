<?php
namespace Application\Entity\Groups;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="groups")
*/

class Groups extends Entity {
	
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
	 * @ORM\Column(type="string", length=10)
	 * @var string
	 */
	protected $name;
	
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