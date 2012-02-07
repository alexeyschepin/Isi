<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author Alex
 */
class Isi_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
    
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = Isi_Acl::getInstance();
 
        if (Zend_Auth::getInstance()->getIdentity() != null) {
            $role = Zend_Auth::getInstance()->getIdentity()->role;
        } else {
            $role = Isi_Acl::DEFAULT_ROLE;
        }
        $request = $this->getRequest();
        $controller = $request->controller;
        $action = $request->action;

        if (!Isi_Acl::getInstance()->isAllowed($role, $controller, $action)
                && $action !=='error' && $controller !=='error') {
            throw new Zend_Acl_Exception('Not allowed', 405);
            //$this->_response->setRedirect('/error/notallowed');
        }
    }
    
}

?>
