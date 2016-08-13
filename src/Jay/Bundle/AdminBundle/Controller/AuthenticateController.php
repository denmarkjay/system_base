<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/31/2016
 * Time: 4:43 PM
 */

namespace Jay\Bundle\AdminBundle\Controller;


use Jay\Bundle\AdminBundle\Model\UserPeer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\EventListener\ExceptionListener;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AuthenticateController extends Controller
{

    public function indexAction(Request $req)
    {
        //start app
        $app = new AppController($this);
        if($app->accessApp()) $return = $app->redirectToAdmin( $this);
        else $return = $this->render('JayAdminBundle:Pages:login.html.twig');

        return $return;
    }

    public function getLoginForm( $class)
    {
        return $class->render('JayAdminBundle:Pages:login.html.twig');
    }

    public function loginAction(Request $request)
    {
        $param      = $request->request->all();
        $user       = stripcslashes($param['username']);
        $password   = stripcslashes(SHA1($param['password']));
        $user       = UserPeer::loginUserRecord($user, $password);

        if($user) {
            $set = $this->setActive($user);
            if($set) {
                return new JsonResponse(array('res' => 'success'));
            }
        }

        return new JsonResponse(array('res' => 'error'));

    }

    public function setActive( $user)
    {
        $session = new Session();
        $session_array = array(
            'user_id'       =>  $user->getUserId(),
            'user_role'     =>  $user->getUserRole(),
            'user_fname'    =>  $user->getUserFName(),
            'user_lname'    =>  $user->getUserLName(),
            'user_companykey'  =>  $user->getUserCompanyKey(),
            'user_email'    =>  $user->getUserEmail(),
        );
        $session->clear();

        foreach ($session_array as $sessKey => $sess) {
            $session->set($sessKey, $sess);
        }

        return true;
    }

    public function checkSessionAction(Request $req)
    {

        if($req->getMethod() !== 'POST') {
            throw new AccessDeniedException();
        }

        $app     = new AppController($this);
        $session = true;

        if(! $app->accessApp()) {
            $session = false;
        }

        return new JsonResponse(array('session' => $session));
    }


    public function logoutAction()
    {
        $session = new Session();
        $session->clear();
        session_destroy();

        return $this->redirect('/login');
    }

}