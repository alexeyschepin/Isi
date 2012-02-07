<?php

/**
 * Description of NotIdentical
 *
 * @author SkipperVasa
 */
class ZendKinol_Validate_NotIdentical extends Zend_Validate_Identical {

    public function isValid($value) {
        return!parent::isValid($value);
    }

}

?>
