<?php
namespace Application\Entity\Dish;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
use Application\Entity\Dish\DishGroup;

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
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Dish\DishGroup")
     * @var \Application\Entity\Dish\DishGroup
     */
    protected $group;

    /**
     * Dish creation date
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

    public function setGroup(DishGroup $group)
    {
        $this->group = $group;
        $group->addDish($this);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cost' => 1,
        ];
    }

}