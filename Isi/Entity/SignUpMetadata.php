<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Isi\Entity;

/**
 * Description of SignUpMetadata
 * @Entity
 * @Table(name="signUpMetadatas")
 */
class SignUpMetadata {
    
    /**
     * @var int
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var DateTime
     * @Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var string
     * @Column(name="ip", type="string", length=60)
     */
    protected $ip;
        
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    } 
}

?>
