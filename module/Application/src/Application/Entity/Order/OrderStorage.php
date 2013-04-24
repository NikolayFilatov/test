<?php
namespace Application\Entity\Order;

use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_storage")
 */

class OrderStorage extends Entity {

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
     * Order for date
     *
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     */
    protected $date;

    /**
     * Ссылка на запись заказа
     *
     * @ORM\OneToMany(
     *  targetEntity="\Application\Entity\Order\Order",
     *  mappedBy="storage",
     *  cascade={"persist", "remove"}
     * )
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $order;

    /**
     * Status
     * @ORM\Column(type="string", length=10)
     * @var string
     */
    protected $status;

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

    public function getOrderCount()
    {
        return $this->order->count();
    }
}
