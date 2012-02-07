<?php

/**
 * 
 */

namespace Isi\Entity;

/**
 * 
 * @Entity
 * @Table(name="users")
 */
class User {

    /**
     * @var int
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string
     * @Column(type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @var string
     * @Column(type="string", length=60, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string", length=60, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     * @Column(type="string", length=60, nullable=true)
     */
    protected $lastName;
    
    /**
     * @var string
     * @Column(type="string", length=60)
     */
    protected $role = 'member';
    
    /**
     * @var UserCredential
     * @OneToOne(targetEntity="UserCredential", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     * @JoinColumn(name="credentialId", referencedColumnName="id")
     */
    protected $credential;
    
    /**
     * @var SignUpMetadata
     * @OneToOne(targetEntity="SignUpMetadata", orphanRemoval=true, cascade={"persist", "remove", "merge"})
     * @JoinColumn(name="signUpMetadataId", referencedColumnName="id")
     */
    protected $signUpMetadata;
    
    
    public function __get($attribute) {
        return $this->$attribute;
    }

    public function __set($attribute, $value) {
        $this->$attribute = $value;
    }    
    
}

