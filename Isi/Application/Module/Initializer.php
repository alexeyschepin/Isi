<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Initializer
 *
 * @author Alex
 */
abstract class Isi_Application_Module_Initializer extends Zend_Application_Bootstrap_BootstrapAbstract {

    /** @var Offshoot_Application_Module_Bootstrap */
    protected $_bootstrap;

    /**
     *
     * initialize the intializer
     * @param Offshoot_Application_Module_Bootstrap $bootstrap
     * @throws Zend_Application_Bootstrap_Exception
     */
    public function __construct($bootstrap) {

//        if (!$bootstrap instanceof Isi_Application_Module_Bootstrap) {
//            throw new Zend_Application_Bootstrap_Exception(
//                    __CLASS__
//                    . '::__construct expects an instance of '
//                    . 'Isi_Application_Module_Bootstrap'
//            );
//        }

        $this->_bootstrap = $bootstrap;
    }

    /**
     *
     * not used but required by interface
     */
    public function run() {
        
    }

    /**
     * get the bootstrap object that is for the module being initialized
     * @return Offshoot_Application_Module_Bootstrap
     */
    public function getBootstrap() {

        return $this->_bootstrap;
    }

    /**
     * Bootstrap individual, all, or multiple resources
     *
     * @param  null|string|array $resource
     * @return Offshoot_Application_Module_Initializer
     * @throws Zend_Application_Bootstrap_Exception
     */
    final public function initialize($resource = null) {
        //$this->_bootstrap->bootstrap($resource);
        $this->_bootstrap($resource);
        return $this;
    }

}

?>
