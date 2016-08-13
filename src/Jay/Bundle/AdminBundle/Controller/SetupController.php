<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2016
 * Time: 11:52 PM
 */

namespace Jay\Bundle\AdminBundle\Controller;

use Criteria;
use Jay\Bundle\AdminBundle\Model\Company;
use Jay\Bundle\AdminBundle\Model\CompanyPeer;
use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserLevel;
use Jay\Bundle\AdminBundle\Model\UserLevelPeer;
use Jay\Bundle\AdminBundle\Model\UserLogin;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SetupController extends Controller
{

    private $company_key = null;
    public $user = null;
    private $userRole = null;

    public function createAction(Request $req)
    {
        $param      = $req->request->all();
        $company    = $param['data']['company'];
        $user       = $param['data']['user'];

        $res = $this->addCompany($company)
            ->addUserRole()
            ->addUser($user)
            ->login();

        return new JsonResponse(array('result' => $res));
    }

    private function addCompany($companyPost)
    {
        $fetch = false;
        $company_key = "";

        $company = CompanyPeer::searchCompanyByName(stripcslashes($companyPost['company_name']));

        //if company existed
        if(! empty($company)) {
            $this->company_key = $company->getCompanyKey();

            return $this;
        }

        //check if exist key
        while($fetch == false) {
            $company_key = SHA1(rand());
            $ckey = CompanyPeer::searchCompanyKey($company_key);

            if( ! is_null($ckey )) break;
        }

        $company = new Company();
        $company->setCompanyName(stripcslashes($companyPost['company_name']))
            ->setCompanyEmail(stripcslashes($companyPost['company_email']))
            ->setCompanyAddress(stripcslashes($companyPost['company_address']))
            ->setCompanyStatus(stripcslashes('active'))
            ->setCompanyKey(stripcslashes($company_key))
            ->setCompanyDateAdded(date_create())
            ->save()
            ;

        //if success
        if($company)
            $this->company_key = $company_key;

        return $this;
    }

    private function addUserRole() {

        if(empty($this->company_key)) {
            return 'error';
        }

        $uRole = new UserLevel();
        $isUserRole = UserLevelPeer::countUserLevel('SA');

        if($isUserRole) {
            $uRole = UserLevelPeer::fetchUserLevel('SA');
        } else {
            $uRole->setUlRole(stripcslashes('SA'))
                ->setUlName(stripcslashes('Super Admin'))
                ->setUlDateAdded(date_create())
                ->setUlStatus(stripcslashes('active'))
                ->save();
        }

        $this->userRole = $uRole->getUlRole();

        return $this;

    }

    private function addUser($userPost)
    {

        if(empty($this->company_key)) {
            return 'error';
        }

        $key = $this->company_key;

        $user = new User();
        $user->setUserFname(stripcslashes($userPost['user_fname']))
            ->setUserLname(stripcslashes($userPost['user_lname']))
            ->setUserLogin(stripcslashes($userPost['user_login']))
            ->setUserPassword(stripcslashes(SHA1($userPost['user_password'])))
            ->setUserEmail(stripcslashes($userPost['user_email']))
            ->setUserPhone(stripcslashes($userPost['user_phone']))
            ->setUserStatus(stripcslashes('active'))
            ->setUserDateAdded(date_create())
            ->setUserCompanyKey(stripcslashes($key))
            ->setUserRole(stripcslashes('SA'))
            ->save()
            ;

        $this->user = $user;

        return $this;

    }

    private function login()
    {

        $userLogin = new UserLogin();
        $login = $userLogin->setUserlogUid( $this->user->getUserId() )
            ->setUserlogDate(date_create())
            ->save();

        if($login) {
            $session = new Session();
            $session_array = array(
                'user_id' =>  $this->user->getUserId(),
                'user_role'  =>  $this->user->getUserRole(),
                'user_fname'  =>  $this->user->getUserFName(),
                'user_lname'  =>  $this->user->getUserLName(),
                'user_companykey'  =>  $this->user->getUserCompanyKey(),
                'user_email'  =>  $this->user->getUserEmail(),
            );

            $session->clear();
            foreach ($session_array as $sessKey => $sess) {
                $session->set($sessKey, $sess);
            }

            return 'success';
        }

        return 'error';

    }

}