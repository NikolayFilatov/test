<?php
namespace Application\Entity\Dish;

use Zend\ServiceManager\ServiceManager;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use \DateTime;
use \DateTimeZone;

/**
 * @ORM\Entity
 * @ORM\Table(name="dish_group")
 */

class DishGroup extends Entity {

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
     * @ORM\OneToMany(
     * 				targetEntity="Application\Entity\Dish\Dish",
     * 				mappedBy="group",
     * 				cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $dish;

    /**
     * User creation date
     *
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Очередность
     * @ORM\Column(type = "integer")
     */
    protected $level;

    /**
     * Construct
     * Instantiates user entity.
     *
     * @return void
     */
    public function __construct($data = null)
    {
        $this->created = new DateTime('now', new DateTimeZone('UTC'));
        $this->dish = new ArrayCollection();

        return parent::__construct($data);
    }

    public function toArray() {
        $di = [];
        foreach($this->dish as $d)
        {
            $di[] = $d->toArray();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'dish' => $di,
        ];
    }

    public function addDish(Dish $dish)
    {
        $this->dish->add($dish);
    }

    public function getDish($page = 1, $perPage = 25)
    {
        if ($page == 0)
            $slice = $this->dish;
        else
        {
            $limit = (int) $perPage;
            $skip = ((int) $page - 1) * $limit;
            $slice = $this->dish->slice($skip, $limit);
        }

        return $slice;
    }


}
