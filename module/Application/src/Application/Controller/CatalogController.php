<?php

namespace Application\Controller;

use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishService;
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

        $response = [
            'groups' => $groups,
        ];

        $vm = new ViewModel($response);
        $vm->setTemplate('application/catalog/index');

        return $vm;
    }

    public function groupAction()
    {
        $em = $this->getEntityManager();
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        //получим блюда по id группы
        $groupService = new DishGroupService($em);
        $group = $groupService->getGroupById($id);

        $dishService = new DishService($em);
        $dishes = $dishService->getDishesByGroup($group);

        $return = [
            'dishes'    => $dishes,
            'id'        => $id,
            'name'      => $group->getName(),
        ];

        $vm = new ViewModel($return);
        $vm->setTemplate('application/catalog/group');

        return $vm;

    }

}
