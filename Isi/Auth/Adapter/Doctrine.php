<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adapter
 *
 * @author jon
 */
class Isi_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface {
    const MESSAGE_NOT_FOUND_IDENTITY_METHOD = "Identity method is not setup";
    const MESSAGE_CREDENTIAL_INVALID = "Password is not correct";
    const MESSAGE_IDENTITY_NOT_FOUND = "User has not been found";
    const MESSAGE_IDENTITY_FOUND = "User has been found";

    const IDENTIFY_WITH_EMAIL = 'email';
    const IDENTIFY_WITH_USERNAME = 'username';
//    const IDENTIFY_WITH_BOTH = 2;

    protected $_em;

    /**
     *
     * @var User
     */
    protected $_user;

    /**
     *
     * @var int
     */
    protected $_identityMethod;

    /**
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_credentialTreatment - Treatment applied to the credential, such as MD5() or PASSWORD()
     *
     * @var string
     */
    protected $_credentialTreatment = null;

    /**
     *
     * @param type $_identityMethod
     * @param type $_identity
     * @param type $_credential
     * @param type $_credentialTreatment 
     */
//    function __construct($identityMethod, $identity, $credential, $credentialTreatment) {
//        $this->_identityMethod = $identityMethod;
//        $this->_identity = $identity;
//        $this->_credential = $credential;
//        $this->_credentialTreatment = $credentialTreatment;
//    }

    /**
     *
     * @param int $identityMethod
     * @param Isi\Entity\User $user 
     */
    function __construct($identityMethod, $em) {//, \Entity\User $user = null) {
        $this->_identityMethod = $identityMethod;
        $this->_em = $em;

//        if (is_null($user)) {
//            throw new Zend_Auth_Adapter_Exception(self::MESSAGE_IDENTITY_NOT_FOUND);
//        }
//
//        
//        if ($this->_identityMethod == self::IDENTIFY_WITH_EMAIL) {
//            $this->_identity = $user->getEmail();
//        } elseif ($this->_identityMethod == self::IDENTIFY_WITH_USERNAME) {
//            $this->_identity = $user->getUsername();
//        } else {
//            throw new Zend_Auth_Adapter_Exception(self::MESSAGE_NOT_FOUND_IDENTITY_METHOD);
//        }
//
//        $this->_credential = $user->getCredential()->getPassword();
        //$this->_credentialTreatment = $user->getCredential()->getSalt();
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param  string $value
     * @return Zend_Auth_Adapter_DbTable Provides a fluent interface
     */
    public function setIdentity($value) {
        $this->_identity = $value;
        return $this;
    }

    /**
     * setCredential() - set the credential value to be used, optionally can specify a treatment
     * to be used, should be supplied in parameterized form, such as 'MD5(?)' or 'PASSWORD(?)'
     *
     * @param  string $credential
     * @return Zend_Auth_Adapter_DbTable Provides a fluent interface
     */
    public function setCredential($credential) {
        $this->_credential = $credential;
        return $this;
    }

    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        $user = $this->_em->getRepository('Entity\User')
                ->findOneBy(array($this->_identityMethod => $this->_identity));

        if (is_null($user)) {
            return new Zend_Auth_Result(
                            Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                            $user,
                            array(self::MESSAGE_IDENTITY_NOT_FOUND)
            );
        }

        //die(sha1($this->_credential . $user->credential->salt));
        if (sha1($this->_credential . $user->credential->salt) == $user->credential->password) {
            //@todo remove this line. Used to initilaize personalization
            $user->getPersonalization()->getRole();
            // clear unsafe data like password and salt
            $user->clearSensitiveData();
            return new Zend_Auth_Result(
                            Zend_Auth_Result::SUCCESS,
                            $user,
                            array(self::MESSAGE_IDENTITY_FOUND)
            );
        }
        // invalid credentials
        return new Zend_Auth_Result(
                        Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                        $this->_user,
                        array(self::MESSAGE_CREDENTIAL_INVALID)
        );


//        
//        $userRepository = $this->_em->getRepository('Entity\User');
//        if ($this->_identityMethod == self::IDENTIFY_WITH_EMAIL) {
//            $this->_user = $userRepository->findOneBy(array('email' => $this->_identity));
//        } elseif ($this->_identityMethod == self::IDENTIFY_WITH_USERNAME) {
//            $this->_user = $userRepository->findOneBy(array('username' => $this->_identity));
//        } else {
//            throw new Zend_Auth_Adapter_Exception(self::MESSAGE_NOT_FOUND_IDENTITY_METHOD);
//        }
//        if ($this->_user) {
//            //@todo remove this line. Used to initilaize personalization
//            $this->_user->getPersonalization()->getRole();
//            $credential = $this->_user->getCredential();
//            echo $credential->getPassword();
//            echo $credential->getSalt();
//            die();
//            if ($credential->getPassword() == $this->_credential &&
//                    $credential->getSalt() == $this->_credentialTreatment) {
//                // clear unsafe data like password and salt
//                $this->_user->clearSensitiveData();
//                return new Zend_Auth_Result(
//                        Zend_Auth_Result::SUCCESS,
//                        $this->_user,
//                        array(self::MESSAGE_IDENTITY_FOUND)
//                );
//            } else {
//                // invalid credentials
//                return new Zend_Auth_Result(
//                        Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
//                        $this->_user,
//                        array(self::MESSAGE_CREDENTIAL_INVALID)
//                );
//            }
//        } else {
//            // user not found
//            return new Zend_Auth_Result(
//                    Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
//                    $this->_user,
//                    array(self::MESSAGE_IDENTITY_NOT_FOUND)
//            );
//        }
    }

}

