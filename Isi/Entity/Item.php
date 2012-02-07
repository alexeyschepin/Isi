<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Item
 *
 * @author Alex
 */

namespace Isi\Entity;

/**
 * @Entity
 * @Table(name="items")
 */
class Item {
    
    public function __construct() {
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $fractionFrom;
    
    /**
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $fractionTo;
    
    /**
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $price;
    
    /**
     * @ManyToMany(targetEntity="Category")
     * @JoinTable(name="item_category",
     *      joinColumns={@JoinColumn(name="itemId", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="categoryId", referencedColumnName="id")}
     * )
     */
    protected $categories;
    
    /**
     * @OneToMany(targetEntity="Picture", mappedBy="item")
     */
    protected $pictures;
    
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }
}

?>
