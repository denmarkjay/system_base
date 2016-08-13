<?php
/**
 * Created by PhpStorm.
 * User: Pages
 * Date: 7/30/2016
 * Time: 1:19 PM
 */

namespace Jay\Bundle\AdminBundle\Controller;

use Criteria;
use Jay\Bundle\AdminBundle\Model\UserLevelPeer;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends Controller
{
    public function indexAction()
    {
        //set template
        $this->app->setTemplate( $this->app, $this,
            'JayAdminBundle:Pages:dashboard_home.html.twig', array('_user' => $this->app->getUser()) );

        return $this->app->getTemplate();
    }

}