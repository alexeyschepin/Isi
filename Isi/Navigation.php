<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Navigation
 *
 * @author Alex
 */
class Isi_Navigation {
    
    /**
     *
     * @var array|Zend_Config $pages
     */
    protected $_pages;
    
    /**
     *
     * @var Zend_Navigation 
     */
    protected $_navigation;
    
    /**
     *
     * @var type 
     */
    protected $_registredPages = array();
    
    
    public function __construct($pages = null) {
        $this->_pages = $pages;
    }
        
    protected function _load() {
        if ($this->_navigation == null) {
            $this->_navigation = new Zend_Navigation($pages);
        }
    }
    
    public function register(array $code) {
        $this->_registredPages[] = $code;
    }
    
    protected function _loadRegistredPages() {
        foreach ($this->_registredPages as $registredPage) {
            
        }
    }
    
    public function notifyOrderUpdated() {
        $this->_load();
        return $this->_navigation->notifyOrderUpdated();
    }
        
    public function addPage($page) {
        $this->_load();
        return $this->_navigation->addPage($page);
    }

    public function addPages($pages) {
        $this->_load();
        return $this->_navigation->addPages($pages);
    }

    public function setPages(array $pages) {
        $this->_load();
        return $this->_navigation->setPages($pages);
    }

    public function getPages() {
        $this->_load();
        return $this->_navigation->getPages();
    }

    public function removePage($page) {
        $this->_load();
        return $this->_navigation->removePage($page);
    }

    public function removePages() {
        $this->_load();
        return $this->_navigation->removePages();
    }

    public function hasPage(Zend_Navigation_Page $page, $recursive = false) {
        $this->_load();
        return $this->_navigation->hasPage($page, $recursive);
    }

    public function hasPages() {
        $this->_load();
        return $this->_navigation->hasPages();
    }
    
    public function findOneBy($property, $value) {
        $this->_load();
        return $this->_navigation->findOneBy($property, $value);
    }

    public function findAllBy($property, $value) {
        $this->_load();
        return $this->_navigation->findAllBy($property, $value);
    }

    public function findBy($property, $value, $all = false) {
        $this->_load();
        return $this->_navigation->findBy($property, $value, $all);
    }
    
    public function __call($method, $arguments) {
        $this->_load();
        return $this->_navigation->__call($method, $arguments);
    }

    public function toArray() {
        $this->_load();
        return $this->_navigation->toArray();
    }

    public function current() {
        $this->_load();
        return $this->_navigation->current();
    }
    
    public function key() {
        $this->_load();
        return $this->_navigation->key();
    }
    
    public function next() {
        $this->_load();
        return $this->_navigation->next();
    }

    public function rewind() {
        $this->_load();
        return $this->_navigation->rewind();
    }

    public function valid() {
        $this->_load();
        return $this->_navigation->valid();
    }
    
    public function hasChildren() {
        $this->_load();
        return $this->_navigation->hasChildren();
    }
    
    public function getChildren() {
        $this->_load();
        return $this->_navigation->getChildren();
    }

    public function count() {
        $this->_load();
        return $this->_navigation->count();
    }
   
    
    
}

?>
