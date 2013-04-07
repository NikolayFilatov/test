<?php
namespace Application\Entity\Company;

use Application\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="companies")
*/

class Company extends Entity {
	
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
	 * @ORM\Column(type="string", length=50)
	 * @var string
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=1024)
	 * @var string
	 */
	protected $description;
	
	
	
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