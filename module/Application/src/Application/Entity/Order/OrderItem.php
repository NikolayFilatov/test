<?php
namespace Application\Entity\Order;

use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_item")
 */

class OrderItem extends Entity {

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
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Menu\Menu")
     * @var \Application\Entity\Menu\Menu
     */
    protected $menu;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Order\Order")
     * @var \Application\Entity\Order\Order
     */
    protected $order;

    /**
     * @ORM\Column(type = "integer")
     * @var int
     */
    protected $count = 1;

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

    public function getCost()
    {
        $this->menu->getCost() * $this->count;
    }
}