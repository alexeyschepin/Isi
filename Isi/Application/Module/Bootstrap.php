<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author Alex
 */
class Isi_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap {

    /**
     * Constructor
     *
     * @param  Zend_Application|Zend_Application_Bootstrap_Bootstrapper 
     *     $application
     * @return void
     */
    public function __construct($application) {
        parent::__construct($application);
        $this->_loadModuleConfig();
        $this->_loadInitializer();
    }

    /**
     *
     * load a module specific config file
     */
    protected function _loadModuleConfig() {
        // would probably better to use 
        // Zend_Controller_Front::getModuleDirectory() ?
        $configFile = APPLICATION_PATH
                . '/modules/'
                . strtolower($this->getModuleName())
                . '/configs/module.ini';

        if (!file_exists($configFile)) {
            return;
        }

        $config = new Zend_Config_Ini($configFile, $this->getEnvironment());
        $this->setOptions($config->toArray());
    }

    /**
     *
     * add the bootstrap intializer to the resource loader
     */
    public function _loadInitializer() {
        $this->getResourceLoader()->addResourceType(
                'Bootstrap_Initializer', 'bootstrap', 'Bootstrap'
        );
    }

}

?>
