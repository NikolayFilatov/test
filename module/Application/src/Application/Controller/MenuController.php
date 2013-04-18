<?php

namespace Application\Controller;

use Application\Entity\Dish\Dish;
use Application\Entity\Dish\DishGroupService;
use Application\Entity\Dish\DishGroup;
use Application\Entity\Dish\DishService;
use Application\Entity\User\User;
use Application\Entity\User\UserService;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class MenuController extends AbstractActionController
{
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    public function indexAction()
    {
        $em = $this->getEntityManager();

        $user = $this->zfcUserAuthentication()->getIdentity();

        $vm = new ViewModel();
        $vm->setTemplate('application/menu/index');

        return $vm;
    }

    public function dishAction()
    {
        $em = $this->getEntityManager();

        //test
        $dishGroupService = new DishGroupService($em);
        $dishService = new DishService($em);
        $dish = new Dish([
            'name' => 'SecondDish in SecondGroup',
        ]);
//        $firstGroup = $dishGroupService->findDishGroupById(2);
//        $dish->setGroup($firstGroup);
//        $dishGroupService->save($firstGroup);

//        $dishService->save($dish);
//        $dishGroupService->delete($firstGroup);

        $dg = $dishGroupService->getAllDishGroup();

        $response = ['groups' => $dg];

        $vm = new ViewModel($response);
        $vm->setTemplate('application/menu/dish');

        return $vm;
    }

}
