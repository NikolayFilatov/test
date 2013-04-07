<?php
namespace Application\Entity;


/**
 * @category    Projectshift
 * @package     ShiftCommon
 * @subpackage  Model
 */
abstract class Entity
{

    /**
     * Protected properties
     * @var array
     */
    protected $protectedProperties = array();


    /**
     * Construct object
     *
     * @param mixed $data
     * @return Entity
     */
    public function __construct($data = null)
    {
        //Populate
        if(is_array($data))
            $this->fromArray($data);
        if(is_string($data))
            $this->fromJson($data);
    }


    /**
     * (implement me:)
     * Access array representation of current Group object
     * @return array
     */
    abstract public function toArray();


    /**
     * Populate current object with data
     * @param $data
     * @return Entity
     */
    public function fromArray(array $data = array())
    {
        foreach($data as $property => $value)
        {
            if(!$this->isProtectedProperty($property))
            {
                $setter = 'set' .  ucfirst($property);
                if(method_exists($this, $setter))
                    $this->$setter($value);
                elseif(property_exists($this, $property))
                    $this->$property = $value;
            }
        }
        return $this;
    }


    /**
     * Return current object representation as JSON
     * @return string
     */
    public function toJson()
    {
        $jsonObject = $this->toArray();
        return json_encode($jsonObject);
    }


    /**
     * Return current object representation as JSON
     * @param string $data
     * @return Entity
     */
    public function fromJson($data = '')
    {
        if(empty($data))
            return;

        $jsonObject = json_decode($data);
        $dataArray = (array)$jsonObject; // stdClass to array

        $this->fromArray($dataArray);
        return $this;
    }


    /**
     * Get protected properties
     * @return array
     */
    public function getProtectedProperties()
    {
        return $this->protectedProperties;
    }


    public function isProtectedProperty($property)
    {
        return in_array($property, $this->protectedProperties);
    }

    /**
     * Emulate getters & setters for class properties
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method = null, $arguments = array())
    {
        //use as getter
        if(empty($arguments) && 'get' == substr($method, 0, 3))
        {
            $property = lcfirst(substr($method, 3));
            if(property_exists($this, $property))
                return $this->$property;
        }

        //use as setter
        if(!empty($arguments) && 'set' == substr($method, 0, 3))
        {
            $property = lcfirst(substr($method, 3));
            if(!property_exists($this, $property))
                return;

            //check if protected
            $protectedError  = "Trying to change a protected ";
            $protectedError .= "property '$property'";
            if($this->isProtectedProperty($property))
                throw new DomainException($protectedError, 500);

            //set if not protected
            $value = array_shift($arguments);
            $this->$property = $value;
            return $this;
        }

        //otherwise throw undefined method
        $class = get_called_class();
        $trace = debug_backtrace(false);
        $file = $trace[1]['file'];
        $line = $trace[1]['line'];
        $error  = "Overloading error: Call to undefined method ";
        $error .= "$class::$method() in $file on line $line";
        trigger_error($error, E_USER_ERROR);
    }

	public function __get($name)
	{
		return $this->$name;
	}
}