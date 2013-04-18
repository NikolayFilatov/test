<?php
namespace Application\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class DateFormat extends AbstractPlugin {
	
    function __construct() {
    }
    
    function getDay($date)
    {
        $iD = date('d', $date->getTimestamp());
        $iM = date('m', $date->getTimestamp());
        $iY = date('y', $date->getTimestamp());

        $date->setTimestamp(mktime(0, 0, 0, $iM, $iD, $iY));
        return $date;
    }
}

