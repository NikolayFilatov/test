<?php
namespace Application\Entity\Order;

use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */

class Order extends Entity {

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
     * Ссылка на запись заказа
     *
     * @ORM\OneToMany(
     *  targetEntity="\Application\Entity\Order\OrderItem",
     *  mappedBy="order",
     *  cascade={"persist", "remove"}
     * )
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $item;

    /**
     * @ORM\ManyToOne(targetEntity="\Application\Entity\User\ZfcUser")
     * @var \Application\Entity\User\ZfcUser
     */
    protected $user;

    /**
     * OrderStorage
     *
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Order\OrderStorage")
     * @var \Application\Entity\Order\OrderStorage
     */
    protected $storage;

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

    public function getTotal()
    {
        $total = 0;
        foreach($this->item as $item)
        {
            $total = $total + $item->getCost();
        }

        return $total;
    }

    public function getCountItem()
    {
        return $this->item->count();
    }
}
