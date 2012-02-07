<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lucene
 *
 * @author Alex
 */
class Isi_Controller_Action_Helper_Lucene extends Zend_Controller_Action_Helper_Abstract {

    protected $_index;

    public function __construct() {
        $personalization = Zend_Registry::get('personalization');

        $analyzer = new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive();
        $morphy = new Isi_Search_Lucene_Analysis_TokenFilter_Morphy(
                        $personalization->getLocale());
        $analyzer->addFilter($morphy);
        Zend_Search_Lucene_Analysis_Analyzer::setDefault($analyzer);
        Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');

        $lucene = $this->_config['lucene'];
        $indexPath = $lucene['indexPath'] . 'items/' . $personalization->getLocale();

        if (!$this->_directory->fileExists($indexPath)) {
            $create = true;
        }

        if (!is_dir($indexPath)) {
            $this->_index = Zend_Search_Lucene::create($indexPath);
        } else {
            $this->_index = Zend_Search_Lucene::open($indexPath);
        }
    }

//    public function createindex() {
//        //$index = Zend_Search_Lucene::create($this->_indexPath);
//        $items = $this->_em->getRepository('Entity\Item')->findAll();
//        //$items = $this->_em->getRepository('Entity\Category')->findAll();
//        foreach ($items as $item) {
//            $this->_generateItemDocument($item);
//            //$index->addDocument($this->_generateCategoryDocument($item));
//        }
//        $this->_index->commit();
//        $this->_index->optimize();
//
//        echo "Indexes created successfully.";
//    }

    protected function _generateDocument($entity) {
        switch (get_class($entity)) {
            case 'Item':
                return _generateItemDocument($entity);
                break;
            default:
                throw new Zend_Exception('The entity does not exist', 500);
        }
    }

    protected function _generateItemDocument(\Entity\Item $entity) {
        $doc = new Zend_Search_Lucene_Document();
        $doc->addField(Zend_Search_Lucene_Field::keyword('pk', $entity->id, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::text('name', $entity->name, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::text('description', $entity->description, 'utf-8'));
        //$doc->addField(Zend_Search_Lucene_Field::unIndexed('slug', $entity->slug, 'utf-8'));
        // add item's category and its ancestors
        $categories = implode(",", $entity->category->getParentNamesTree());
        $doc->addField(Zend_Search_Lucene_Field::text('categories', $categories, 'utf-8'));

        // add item's text
        $text = strip_tags($entity->text);
        $doc->addField(Zend_Search_Lucene_Field::unStored('text', $text, 'utf-8'));

        $this->_index->addDocument($doc);
        //return $doc;
    }

//    protected function _generateCategoryDocument(\Entity\Category $entity) {
//        $doc = new Zend_Search_Lucene_Document();
//
//        // id
//        $id = $entity->getId();
//        $doc->addField(Zend_Search_Lucene_Field::keyword('pk', $id, 'utf-8'));
//
//        // add name field
//        $name = $entity->getName()->getName();
//        //echo mb_detect_encoding($name);
//        $doc->addField(Zend_Search_Lucene_Field::text('name', $name, 'utf-8'));
//
//        // add item's slug
//        $slug = $entity->getName()->getSlug();
//        $doc->addField(Zend_Search_Lucene_Field::unIndexed('slug', $slug, 'utf-8'));
//
//        return $doc;
//    }

    public function createDocument($entity) {
//        $params = $this->getRequest()->getParams;
//        print_r($params);
////        print_r($this->_getParams());
////        print_r($this->_getParam('entity'));
//        
//        //$entity = $this->getRequest()->getParam('entity');
//
//        echo $entity;
//        die();
        //$entity = $this->getRequest()->getParam('entity');
        $this->_generateItemDocument($entity);
        $this->_index->optimize();
    }

    public function updateDocument($entity) {
        //$entity = $this->getRequest()->getParam('entity');
        $this->_updateDocument($entity);
        $this->_index->optimize();
    }

    public function deleteDocument($entity) {
        //$entity = $this->getRequest()->getParam('entity');
        $this->_generateDocument($entity);
        $this->_index->optimize();
    }

    protected function _updateDocument($entity) {
        $this->_deleteDocument($entity->id);
        $this->_generateDocument($entity);
    }

    protected function _deleteDocument($documentId) {
        $hits = $this->_index->find('pk:' . $documentId);
        foreach ($hits as $hit) {
            $this->_index->delete($hit->id);
        }
        //$this->_index->optimize();
    }

    public function gosearchAction() {
        $searchForm = new App_Form_Lucene_Search();
        if ($this->getRequest()->isPost()) {
            $params = $this->getRequest()->getPost();
            if ($searchForm->isValid($params)) {
                $index = Zend_Search_Lucene::open($this->_indexPath);
                $hints = $index->find($searchForm->getValue('search'));
                if ($hints) {
                    foreach ($hints as $hint) {
                        $items[] = $this->_em->find('Entity\Item', $hint->pk);
                    }
                    $this->view->items = $items;
                }
            }
        }
    }

//    protected function _searchDocument($entity) {
//        switch (get_class($entity)) {
//            case 'Item':
//                return _generateItemDocument($entity);
//                break;
//            default:
//                
//        }
//    }
//    
//    protected function _searchItemDocument(\Entity\Item $entity) {
//        
//    }
}

?>
