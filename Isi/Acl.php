<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Zend/Acl.php';

/**
 * Description of Acl
 *
 * @author Alex
 */
class Isi_Acl extends Zend_Acl {
    const DEFAULT_ROLE = 'guest';

    /**
     * Instance jedinУЁФkХЏ
     *
     * @var array obsahuje ACL objekty
     */
    protected static $_instances = array();

    /**
     * ZУ­skУЁnУ­ instance
     * 
     * @param string $module NУЁzev modulu
     * @return Mabo_Acl
     */
    public static function getInstance($path = '/configs/acl.ini') {

        // Otestuj, zda existuje instance a vytvoХ v pХУ­padФ potХeby
        if (!isset(self::$_instances[$path])) {
            self::$_instances[$path] = new self($path);
        }

        // VraХЅ instanci
        return self::$_instances[$path];
    }

    /**
     * VytvoХУ­ ACL
     * 
     * @param string $module NУЁzev modulu
     */
    protected function __construct($path = '/configs/acl.ini') {
        // naФУ­tУЁ ACL z INI souboru
        $config = new Zend_Config_Ini(APPLICATION_PATH . $path);


        // vytvoХУ­ uХОivatelskУЉ role
        foreach ($config->roles as $role) {
            $this->addRole(new Zend_Acl_Role($role));
        }

        // vytvoХУ­ zdroje
        foreach ($config->resources as $resource) {
            $resources = explode(':', $resource);
            if (count($resources) == 1) {
                $this->addResource(new Zend_Acl_Resource($resources[0]));
            } else {
                $this->addResource(new Zend_Acl_Resource($resource), $resources[0]);
            }
        }

        // vytvoХУ­ pravidla
//        foreach ($config->rules as $permission => $rules) {
//            foreach ($rules as $role => $rule) {
//                foreach ($rule as $resource => $privilege) {
//                    $privilege = $rule->toArray();
//                    if (!is_array($privilege)) {
//                        if ('all' == $privilege) {
//                            $this->$permission($role, $resource);
//                        } else {
//                            if (is_array($privilege)) {
//                                $privilege = $privilege->toArray();
//                            }
//                            $this->$permission($role, $resource, $privilege);
//                        }
//                    } else {
//                        $subResources = $privilege;
//                        foreach ($subResources as $subResource => $privilege) {
//                            $res = "$resource:$subResource";
//                            print_r($res);
//                            if ('all' == $privilege) {
//                                $this->$permission($role, $res);
//                            } else {
//                                if (is_array($privilege)) {
//                                    $privilege = $privilege->toArray();
//                                }
//                                $this->$permission($role, $res, $privilege);
//                            }
//                        }
//                    }
//                }
//            }die();
//        }
        foreach ($config->rules as $permission => $rules) {
            foreach ($rules as $role => $rule) {
                foreach ($rule as $resource => $privilege) {
                    if ('all' == $privilege) {
                        $this->$permission($role, $resource);
                    } else {
                        if (is_array($privilege)) {
                            $privilege = $privilege->toArray();
                        }
                        $this->$permission($role, $resource, $privilege);
                    }
                }
            }
        }
    }

    public function isAllowed($role = null, $resource = null, $privilege = null) {
        try {
            return parent::isAllowed($role, $resource, $privilege);
        } catch (Zend_Acl_Exception $e) {
            $resources = explode(':', $resource);
            if (count($resources) == 2) {
                return parent::isAllowed($role, $resources[0], $privilege);
            } else {
                throw new Zend_Acl_Exception("Resource '$resource' not found");
            }
        }
    }

}

?>
