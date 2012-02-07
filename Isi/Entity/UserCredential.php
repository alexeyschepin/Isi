<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Isi\Entity;

/**
 * 
 * @Entity
 * @Table(name="userCredentials")
 */
class UserCredential {
    
    /**
     * @var int
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var String
     * @Column(name="password", type="string", length=60, nullable=true)
     */
    protected $password;

    /**
     * @var String
     * @Column(name="salt", type="string", length=60, nullable=true)
     */
    protected $salt;    
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    } 
}

?>
