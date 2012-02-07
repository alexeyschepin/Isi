<?php

require_once 'Zend/Validate/Abstract.php';

class Isi_Validate_Db_NoRecordExists extends Zend_Validate_Abstract {

    private $_em;
    private $_table;
    private $_field;

    const ERROR_RECORD_FOUND = 'recordFound';

    protected $_messageTemplates = array(
        self::ERROR_RECORD_FOUND => "A record matching '%value%' was found"
    );

    public function __construct($table, $field) {
        $this->_em = Zend_Registry::get('em');
        $this->_table = $table;
        $this->_field = $field;
    }

    public function isValid($value) {
        $this->_setValue($value);
        $funcName = 'findBy' . $this->_field;

        if (count($this->_em->getRepository($this->_table)->$funcName($value)) > 0) {
            $this->_error(self::ERROR_RECORD_FOUND);
            return false;
        }

        return true;
    }

}

?>