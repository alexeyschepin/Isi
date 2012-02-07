<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author Alex
 */

namespace Isi\Entity;

/**
 * @Entity
 * @Table(name="categories")
 */
class Category {
    
    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->name;
    }
    
    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parentId", referencedColumnName="id")
     */
    private $parent;
    
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $name;
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    } 
    
}

?>
