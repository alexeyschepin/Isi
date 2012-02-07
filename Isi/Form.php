<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Form
 *
 * @author Alex
 */
class Isi_Form extends Zend_Form
{
    public function __construct($options = null)
    {
        $this->addPrefixPath('Isi_Form_', 'Isi/Form/');
        $this->getView()->addHelperPath('Isi/View/Helper', 'Isi_View_Helper');
        parent::__construct($options);
    }
}


?>
