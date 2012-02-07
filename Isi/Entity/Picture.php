<?php

/**
 * Description of Picture
 *
 * @author Alex
 */
namespace Isi\Entity;

/**
 * @Entity
 * @Table(name="pictures")
 */
class Picture {
    
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
     * @var string
     * @Column(type="string", length=255)
     */
    protected $description;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $srcSmall;
    
    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $srcLarge;
    
    /**
     * @var Item
     * 
     * @ManyToOne(targetEntity="Item", inversedBy="picture")
     * @JoinColumn(name="itemId", referencedColumnName="id")
     */
    protected $item;
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }  
    
}

?>
