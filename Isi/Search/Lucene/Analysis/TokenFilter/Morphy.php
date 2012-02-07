<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(APPLICATION_PATH . '/../library/PhpMorphy/src/common.php');

/**
 * Description of Morphy
 *
 * @author Alex
 */
class Isi_Search_Lucene_Analysis_TokenFilter_Morphy extends Zend_Search_Lucene_Analysis_TokenFilter {

    protected $_dir;
    protected $_locale;
    protected $_morphy;

    public function __construct($locale) {
        $this->_locale = $locale;
        $this->_dir = APPLICATION_PATH . '/../library/PhpMorphy/dicts/';
        switch ($this->_locale) {
            case 'ru_RU':
                $this->_dir .= 'utf-8';
                break;
            case 'de_DE':
                $this->_dir .= 'utf-8';
                break;
            case 'en_US':
                $this->_dir .= 'windows';
                break;
            default:
                throw new Zend_Exception('Unknown locale', 500);
        }

        $this->_morphy = new phpMorphy($this->_dir, $this->_locale);
    }

    public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken) {
        //извлекаем корень слова
        $pseudo_root = $this->_morphy->getPseudoRoot(mb_strtoupper($srcToken->getTermText(), 'utf-8'));
        if ($pseudo_root === false)
            $newStr = mb_strtoupper($srcToken->getTermText(), 'utf-8');
        //если корень извлечь не удалось, тогда используем все слово целиком
        else
            $newStr = $pseudo_root[0];

        //если лексема короче 3 символов, то не используем её      
        if (mb_strlen($newStr, 'utf-8') < 3)
            return null;

        $newToken = new Zend_Search_Lucene_Analysis_Token(
                        $newStr,
                        $srcToken->getStartOffset(),
                        $srcToken->getEndOffset()
        );

        $newToken->setPositionIncrement($srcToken->getPositionIncrement());

        return $newToken;
    }

}

?>
