<?php
namespace Application\Entity\Dish;

use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;
use \DateTimeZone;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish")
 */

class Dish extends Entity {

    protected $protectedProperties = [
        'id',
        'created',
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     *
     */
    protected $group;

    /**
     * User creation date
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


    public function toArray() {
        return [
            'is' => $this->id,
            'name' => $this->name,
            'cost' => 1,
        ];
    }

}