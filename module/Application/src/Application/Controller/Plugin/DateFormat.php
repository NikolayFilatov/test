<?php
namespace Application\Controller\Plugin;
use \DateTime;
use \DateTimeZone;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DateFormat extends AbstractPlugin {
	
    public function __construct() {
    }
    
    public function getDay($date)
    {
        $iD = date('d', $date->getTimestamp());
        $iM = date('m', $date->getTimestamp());
        $iY = date('y', $date->getTimestamp());

        $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));
        return $date;
    }

    public function getCurDay()
    {
        $date = new DateTime('now', new \DateTimeZone('UTC'));

        $iD = date('d', $date->getTimestamp());
        $iM = date('m', $date->getTimestamp());
        $iY = date('y', $date->getTimestamp());

        $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));
        return $date;
    }

}

