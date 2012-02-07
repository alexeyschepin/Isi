<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Article
 *
 * @author Alex
 */

namespace Isi\Entity;

use Gedmo\Translatable\Translatable;
use Gedmo\Timestampable\Timestampable;

/**
 * @Entity
 * @Table(name="articles")
 */
class Article implements Translatable {
    
    public function __construct() {
        $this->keywords = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var int
     * @Column(type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
        
    /**
     * @var User
     * 
     * @ManyToOne(targetEntity="User", inversedBy="article")
     * @JoinColumn(name="author", referencedColumnName="id")
     */
    protected $author;
        
    /**
     * @var DateTime
     * 
     * @gedmo:Timestampable(on="create")
     * @Column(type="datetime")
     */
    protected $created;
    
    /**
     * @var DateTime
     * 
     * @gedmo:Timestampable(on="update")
     * @Column(type="datetime")
     */
    protected $modified;
    
    /**
     * @var string
     * @gedmo:Translatable
     * @Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @var string
     * @gedmo:Translatable
     * @Column(type="text", nullable=true)
     */
    protected $content;
        
    /**
     * @ManyToMany(targetEntity="Keyword")
     * @JoinTable(name="article_keyword",
     *      joinColumns={@JoinColumn(name="articleId", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="keywordId", referencedColumnName="id")}
     * )
     */
    protected $keywords;
        
    /**
     * @gedmo:Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
 
    public function getTitle() {
        return $this->title;
    }
 
    public function setContent($content) {
        $this->content = $content;
    }
 
    public function getContent() {
        return $this->content;
    }
    
    public function setTranslatableLocale($locale) {
        $this->locale = $locale;
    }
    
    public function toArray() {
        $array = array(
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        );
        return $array;
    }
}

?>