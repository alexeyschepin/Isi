<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveModule
 *
 * @author Alex
 */
class Isi_Controller_Plugin_ActiveModule extends Zend_Controller_Plugin_Abstract {

    public function routeShutdown(Zend_Controller_Request_Abstract $request) {

        $activeModuleName = $request->getModuleName();
        //$activeBootstrap = $this->_getActiveBootstrap($activeModuleName);
        $activeBootstrap = $this->_getBootstrap();

        //if ($activeBootstrap instanceof Isi_Application_Module_Bootstrap) {

            $className = ucfirst($activeModuleName) . '_Bootstrap_Initializer';

            // don't assume that every module has an initializer...
            if (class_exists($className)) {
                $intializer = new $className($activeBootstrap);
                $intializer->initialize();
            }
        //}
    }

    /**
     * return the default bootstrap of the app
     * @return Zend_Application_Bootstrap_Bootstrap
     */
    protected function _getBootstrap() {
        $frontController = Zend_Controller_Front::getInstance();
        $bootstrap = $frontController->getParam('bootstrap');
        return $bootstrap;
    }

    /**
     * return the bootstrap object for the active module
     * @return Offshoot_Application_Module_Bootstrap
     */
    public function _getActiveBootstrap($activeModuleName) {

        $moduleList = $this->_getBootstrap()->getResource('modules');

        if (isset($moduleList[$activeModuleName])) {
            return $moduleList[$activeModuleName];
        }

        return null;
    }

}

?>
