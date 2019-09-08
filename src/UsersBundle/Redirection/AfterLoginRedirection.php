<?php
/**
 * Created by PhpStorm.
 * User: yassi
 * Date: 06/02/2018
 * Time: 11:18 PM
 */

namespace UsersBundle\Redirection;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;
    /**
     * @param RouterInterface $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return Router|RouterInterface
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param Router|RouterInterface $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_BAKERY', $rolesTab, true) )
            $redirection = new RedirectResponse($this->router->generate('mystock_bakery'));
        elseif (in_array('ROLE_BRAND', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('route_test'));
        elseif (in_array('ROLE_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('all_categories_admin'));
        elseif (in_array('ROLE_DELIVERYMAN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('delivery_show_planning'));
        else
            $redirection = new RedirectResponse($this->router->generate('front_homepage'));
        return $redirection;
    }

}