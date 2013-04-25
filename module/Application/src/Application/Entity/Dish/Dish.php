<?php
namespace Application\Entity\Dish;

use Application\Entity\Price\Price;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Tests\ORM\Functional\Ticket\DDC513Price;
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
     * Ссылка на стоимость
     *
     * @ORM\OneToMany(
     *  targetEntity="\Application\Entity\Price\Price",
     *  mappedBy="dish"
     * )
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $price;

    /**
     * Deleted
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $deleted = 0;

    /**
     * Construct
     * Instantiates user entity.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->created = new DateTime('now', new DateTimeZone('UTC'));
        $this->price = new ArrayCollection();

        return parent::__construct($data);
    }

    public function setGroup(DishGroup $group)
    {
        $this->group = $group;
        $group->addDish($this);
    }

    public function toArray() {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'cost'      => $this->getCost(),
            'groupName' => $this->group->getName(),
            'groupId'   => $this->group->getId(),
        ];
    }

    public function addPrice(Price $price)
    {
        $this->price->add($price);
    }

    public function getCost()
    {
        if (count($this->price) == 0)
            return 0;

        $price = $this->price->last();
        return $price->getCost();
    }

    public function getLastDatePrice()
    {
        if (count($this->price) == 0)
            return 0;

        $price = $this->price->last();
        return $price->getDate();
    }

    public function markDelete()
    {
        $this->deleted = 1;
    }

    public function markUnDelete()
    {
        $this->deleted = 0;
    }

    public function isDeleted()
    {
        return $this->deleted;
    }
}