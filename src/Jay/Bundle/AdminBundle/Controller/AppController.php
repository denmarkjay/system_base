<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/31/2016
 * Time: 2:21 PM
 */

namespace Jay\Bundle\AdminBundle\Controller;


use Jay\Bundle\AdminBundle\Model\User;
use Jay\Bundle\AdminBundle\Model\UserPeer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 *
 * add to Controller class if upgraded the symfony version
 *
 *   public $app;
 *   function __construct()
 *   {
 *      $this->app = new AppController( $this);
 *   }
 */

class AppController extends Controller
{
    protected $ready;       //check if setup ready
    protected $access;      //check if user is accessible
    protected $origin;      //callback class
    protected $user;        //active user
    protected $response;    //template

    private   $session;

    /**
     * AppController constructor
     * @param null $class
     */
    function __construct( $class = null)
    {
        $this->session  = new Session();
        $this->origin   = $class;
        $this->ready    = $this->prepareApp();
        $this->access   = $this->accessApp();

        if ($this->access) {
            $user_id    = $this->session->get('user_id');
            $this->user = UserPeer::getUserById($user_id);
        }

        return $this;
    }

    /**
     * Render app setup/login
     * @return response
     */
    public function renderAppAction( $template)
    {
        $auth = new AuthenticateController();
        if($template == 'setup')
            $r = $this->render('JayAdminBundle:Pages:admin_create.html.twig', array('role' => 'SA'));
        else if($template == 'login')
            $r = $auth->getLoginForm($this);

        return $r;
    }

    /**
     * Check if setup done!
     * @return int
     */
    public function prepareApp()
    {
        $userCount = UserPeer::countUserByLevel('SA');

        return $userCount;
    }

    /**
     * Check if accessible
     * @return boolean
     */
    public function accessApp( $isAccess = false)
    {
        //check if logged
        if(! is_null($this->session->get('user_id')))
            $isAccess = true;

        return $isAccess;
    }

    /**
     * Get active user
     * @return array
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the template to be rendered
     *
     * @param class
     * @param class
     * @param template
     * @param array
     * @return object
     */
    public function setTemplate( $app = null, $origin = null, $template = null, $param = array())
    {

        //if app is not yet setup
        //no super admin account
        if(! $app->ready)
            $this->response = $app->forwardToSetup($origin, $param);
        else if(! $app->access)
            $this->response = $origin->redirectToRoute('jay_payroll_admin_login_path');
        else
            $this->response = $origin->render($template, $param);

        return $this;

    }

    /**
     * Get final template
     * @return object
     */
    public function getTemplate()
    {
        return $this->response;
    }

    /**
     * Forward to setup template
     * @return object
     */
    public function forwardToSetup( $origin, $param = array())
    {
        $r = $origin->forward(
            'JayAdminBundle:App:renderApp', array('template' => 'setup')
        );

        return $r;
    }

    /**
     * Redirect to admin
     * @return object
     */
    public function redirectToAdmin( $origin,  $param = array())
    {

        $r = $origin->redirectToRoute('jay_payroll_admin_home');

        return $r;
    }

    /**
     * Access app via ajax
     * @return boolean
     */
    public function accessAppAjax($param)
    {
        if(!$this->accessApp() || empty($param['ajax'])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $response
     * @return JsonResponse
     */
    public function sendError($response = array())
    {
        $response['auth'] = false;

        return new JsonResponse($response);
    }

    /**
     * @param array $response
     * @return JsonResponse
     */
    public function sendSuccess($response = array())
    {
        $response['auth'] = true;

        return new JsonResponse($response);
    }

    public function getVars()
    {
        $vars = array();
        //user roles
        $vars['userRoles'] = UserController::getUserRoles();

        return $vars;
    }


}