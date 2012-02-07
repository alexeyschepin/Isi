<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once 'Zend/Controller/Action';

/**
 * Description of Action
 *
 * @author Alex
 */
class Isi_Controller_Action extends Zend_Controller_Action {

    protected $_em;
    protected $_personalization;
    protected $_config;

    public function init() {
        $this->_config = Zend_Registry::get('config');

        $this->_em = Zend_Registry::get('em');
        $this->_personalization = Zend_Registry::get('personalization');

//        $uri = $this->getRequest()->getPathInfo();
//        if (strlen($uri)> 1) {
//            $uri = rtrim($uri, '/');
//        }
    //$page = $this->view->navigation()->current();
    //$page->active = true;
//print_r($page);
        
        //die($uri);
//        $activeNav = $this->view->navigation()->findActive($this->view->navigation()->getContainer());//$this->view->navigation()->findByUri($uri);
//        print_r($activeNav);
//        die();
//        if (!is_null($activeNav)) {
//            $activeNav->active = true;
//        } else {
//            //throw new Zend_Controller_Router_Exception('Route not found', 404);
//        }
        //var_dump($activeNav);
        //$activeNav->setClass("current-product");  
    }

    public function preDispatch() {

        //$acl = Isi_Acl::getInstance();
        //$auth = Zend_Auth::getInstance();
//        if (Zend_Auth::getInstance()->getIdentity() != null) {
//            $role = Zend_Auth::getInstance()->getIdentity()->role;
//        } else {
//            $role = Isi_Acl::DEFAULT_ROLE;
//        }
        $role = $this->_personalization->getRole();
        $request = $this->getRequest();
        
        $resource = '';
        if ($request->module != '') {
            $resource = $request->module . ':';
        } else {
            $resource = 'default:';
        }
        $resource .= $request->controller;
        $action = $request->action;
//        echo $role;
//        echo $controller;
//        echo $action;
//        die();
        if (!Isi_Acl::getInstance()->isAllowed($role, $resource, $action)) {
            //die('aaa');
            $this->_redirect('/admin/auth/signin');
            //throw new Zend_Acl_Exception('Not allowed', 405);
        }
    }

}

?>
