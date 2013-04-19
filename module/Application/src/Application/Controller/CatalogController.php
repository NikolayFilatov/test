<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\User\User;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CatalogController extends AbstractActionController
{
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()
                ->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        $em = $this->getEntityManager();

        $dishGroupService = new DishGroupService($em);
        $groups = $dishGroupService->getAllDishGroup();

//        $gl = $dishGroupService->changeLevel(true);

        $response = [
            'groups' => $groups,
//            'gl' => $gl,
        ];

        $vm = new ViewModel($response);
        $vm->setTemplate('application/catalog/index');

        return $vm;
    }

}
