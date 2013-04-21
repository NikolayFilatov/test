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

    public function setDate(DateTime $date)
    {
        $iD = date('d', $date->getTimestamp());
        $iM = date('m', $date->getTimestamp());
        $iY = date('y', $date->getTimestamp());

        $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));

        $this->date = $date;

        return $this;
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
