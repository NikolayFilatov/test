<?php

/**
 * @namespace
 */
namespace Application\Form;
use Zend\Form\Form;
use Zend\Form\FormInterface;

/**
 * Wall form
 */
class WallForm extends Form implements FormInterface
{

    public function __construct($name = null) {
         parent::__construct('WallForm');
         $this->setAttribute('method', 'post');
 
        $this->add(array(
           'name' => 'message',
           'type' => 'textarea', 
           'attributes' => array(
           		'type'  => 'textarea',
           		'class' => 'geoTXT txtWall',
           ),
           'options' => array(
               
           ),
        ));
        $this->add(array(
        		'name' => 'cmessage',
        		'type' => 'textarea',
        		'attributes' => array(
        				'type'  => 'textarea',
        				'class' => 'geoTXT txtComment',
        		),
        		'options' => array(
        				 
        		),
        ));        
             
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Отправить',
                'id' => 'submitbutton1',
            	'class' => 'button1 fl_r',
            ),
        ));
        
        $this->add(array(
        		'name' => 'idUser',
        		'type' => 'hidden',
        ));
        
        $this->add(array(
        		'name' => 'idMess',
        		'type' => 'hidden',
        ));
        
     }
}
