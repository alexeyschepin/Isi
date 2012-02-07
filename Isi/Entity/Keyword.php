<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Keywords
 *
 * @author Alex
 */

namespace Isi\Entity;

/**
 * @Entity
 * @Table(name="keywords")
 */
class Keyword {
    
    public function __construct() {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
            
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ManyToMany(targetEntity="Article", mappedBy="keywords")
     */
    private $articles;
        
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }
}

?>