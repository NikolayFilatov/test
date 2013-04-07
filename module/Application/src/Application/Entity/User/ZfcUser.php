<?php
namespace Application\Entity\User;


use Application\Entity\Wall\UserWall;

use Zend\ServiceManager\ServiceManager;

use Zend\Filter\Boolean;

use Application\Entity\User\UserContact;

use Application\Entity\Entity as BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use ZfcUser\Entity\UserInterface;
use \DateTime;
use \DateTimeZone;
use Application\Entity\Location\Location;

/**
* @ORM\Entity
* @ORM\Table(name="user")
*/

class ZfcUser extends BaseEntity implements UserInterface {
	
	protected $protectedProperties = [
	'id',
	'created',
	'bag',
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
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string", name="display_name")
     * @var string
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $state;

    /**
     * User creation date
     *
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Firrst name
     *
     * @ORM\Column(type = "string", length = 20)
     * @var string
     */
    protected $firstname;
    
    /**
     * Last name
     *
     * @ORM\Column(type = "string", length = 20)
     * @var string
     */
    protected $lastname;
    
    /**
     * Middle name
     *
     * @ORM\Column(type = "string", length = 20)
     * @var string
     */
    protected $middlename;
    
    /**
     * Последняя активность
     * нужна для вычисления текущих выносливости и уровня ХП
     * тут хранится timestamp
     *
     * @ORM\Column(type = "integer")
     * @var integer
     */
    protected $lastactive;

    /**
     * Пол
     * 
     * @ORM\Column(type = "boolean")
     * @var Boolean
     */
    protected $sex;
    
    /**
     * Дата рождения
     * 
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     */
    protected $birthday;
    
    /**
     * Группа пользователя
     * гость, пользователь, модератор, администратор.
     * 
     * @ORM\ManyToOne(targetEntity="\Application\Entity\Groups\Groups")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * 
     */
    protected $group;
    
    /**
     * Контакты
     * 
     * @ORM\OneToMany(
     * 				targetEntity="Application\Entity\User\UserContact",
     * 				mappedBy="user",
     * 				cascade={"persist", "remove"})
     * 
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $contacts;
    
    /**
     * Аватарка
     * 
     * @ORM\Column(type = "string", length = 255)
     * @var string
     */
    protected $avatar = '/images/0.png';
    
    /**
     * Мини аватар
     * 
     * @ORM\Column(type = "string", length = 255)
     * @var string
     */
    protected $avatarmini = '/images/0.png';
    
    /**
     * Статус (как вконтакте)
     * 
     * @ORM\Column(type = "string", length = 1024)
     * @var string
     */
    protected $status = Null;

    /**
     * Сообщения на стене
     *
     * @ORM\OneToMany(
     * 		targetEntity="Application\Entity\Wall\UserWall",
     * 		mappedBy="user",
     * 		cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $wall;
    
    /**
     * Город
     * 
     * @ORM\Column(type = "string", length = 50)
     * @var string
     */
    protected $city;
    
    /**
     * Фирма
     * 
     * @ORM\ManyToOne(targetEntity="Application\Entity\Company\Company")
     * @var \Application\Entity\Company\Company
     */
    protected $company;
    
    /**
     * Должность
     * 
     * @ORM\Column(type = "string", length = 50)
     * @var string
     */
    protected $post;
    

    /**
     * Construct
     * Instantiates user entity.
     *
     * @return void
     */
    public function __construct($data = null)
    {
    	$this->contacts = new ArrayCollection();
    	$this->wall = new ArrayCollection();
    	$this->created = new DateTime('now', new DateTimeZone('UTC'));
    	
    	return parent::__construct($data);
    }
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     * @return UserInterface
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username.
     *
     * @param string $username
     * @return UserInterface
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     * @return UserInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set displayName.
     *
     * @param string $displayName
     * @return UserInterface
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param string $password
     * @return UserInterface
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state.
     *
     * @param int $state
     * @return UserInterface
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function toArray() {
        return [
        	'is' => $this->id,
        	'username' => $this->username,
        	'sex' => $this->sex,
        ];
    }
    
    /**
     * Добавить контакт
     */
    public function addContact(UserContact $contact)
    {
    	$this->contacts->add($contact);
    	$contact->setUser($this);
    }
    
    /**
     * Добавить сообщение на стену
     */
    public function addWall(UserWall $wall)
    {
    	$wall->setType('user');
    	$this->wall->add($wall);
    	$wall->setUser($this);
    }    
    
    /**
     * Получим полное имя
     */
    public function getFullname()
    {
    	return $this->firstname . " " . $this->lastname;
    }
    
    /**
     * Получить статус
     */
    public function getStatus()
    {
    	if(is_null($this->status) || empty($this->status))
    		return "статус - пусто";
    	
    	return $this->status;
    }
    
    /**
     * Получить записи со стены
     */
    public function getWall($offset = null, $length = null)
    {
    	return $this->wall->slice($offset, $length);;
    }

}