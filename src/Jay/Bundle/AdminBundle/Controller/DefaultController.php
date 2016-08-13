<?php

namespace Jay\Bundle\AdminBundle\Controller;

use Jay\Bundle\AdminBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $user = new User();
        return $this->render('JayAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
