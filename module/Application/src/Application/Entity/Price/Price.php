<?php
namespace Application\Entity\Price;

use Application\Entity\Dish\Dish;
use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="price")
 */

class Price extends Entity {

    protected $protectedProperties = [
        'id',
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * Price for date
     *
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Dish\Dish")
     * @var \Application\Entity\Dish\Dish
     */
    protected $dish;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $cost;

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

    public function toArray() {
        return [
            'id' => $this->id,
            'cost' => $this->cost,
        ];
    }

    public function setDate(DateTime $date)
    {
        $iD = date('d', $date->getTimestamp());
        $iM = date('m', $date->getTimestamp());
        $iY = date('y', $date->getTimestamp());

        $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));

        $this->date = $date;

        return $this;
    }

    public function setDish(Dish $dish)
    {
        $this->dish = $dish;
        $dish->addPrice($this);
    }

}