<?php

namespace Jay\Bundle\AdminBundle\Controller;

use Jay\Bundle\AdminBundle\Model\CompanyPeer;
use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Jay\Bundle\AdminBundle\Utility\Init;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction( )
    {
        //set template
        $this->app->setTemplate( $this->app, $this,
            'JayAdminBundle:Pages:user_list.html.twig', array('_user' => $this->app->getUser()) );

        return $this->app->getTemplate();
    }

    public function createAction()
    {
        $companies = CompanyPeer::getCompanies();

        //set template
        $this->app->setTemplate( $this->app, $this,
            'JayAdminBundle:Pages:user_new.html.twig', array('_user' => $this->app->getUser(), '_companies' => $companies, '_app' => $this->app) );

        return $this->app->getTemplate();
    }

    public function addUserAction(Request $req)
    {
        $param  = $req->request->all();
        $access = $this->app->accessAppAjax($param);

        if(! $access) {
            return $this->app->sendError();
        }
        $param = Init::app_safe_sql_string($param);
        //convert array index to variable
        extract($param);

        //check if edit
        if(!empty($id)) {
            $user = UserPeer::retrieveByPK($id);
        } else {
            $user = new User();
        }

        $userResponse = $user->setUserFname($fname)
            ->setUserLname($lname)
            ->setUserEmail($email)
            ->setUserRole($role)
            ->setUserBirthDate($birthdate)
            ->setUserPhone($phone)
            ->setUserGender($gender)
            ->setUserLogin($username)
            ->setUserPassword(SHA1($password))
            ->setUserStatus('active')
            ->setUserDateAdded(date('now'))
            ->setUserCompanyKey($company)
            ->setUserAddedBy($this->app->getUser()->getUserId())
            ->save()
            ;

        return
            $this->app->sendSuccess(array('success' => $userResponse));
    }


    public static function getUserRoles()
    {
        return array(
          'SA' => 'Super Admin',
          'AD' => 'Administrator',
          'EM' => 'Employee',
        );
    }
}
