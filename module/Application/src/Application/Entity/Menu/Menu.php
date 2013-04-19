<?php
namespace Application\Entity\Menu;

use Application\Entity\Dish\Dish;
use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;
use \DateTimeZone;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu")
 */

class Menu extends Entity {

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
     * Menu for date
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
        ];
    }

    public function setDish(Dish $dish)
    {
        $this->dish = $dish;
    }

    public function getCost()
    {
        return $this->dish->getCost();
    }

}