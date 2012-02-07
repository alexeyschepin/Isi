<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleRepository
 *
 * @author Alex
 */
class ArticleRepository extends EntityRepository {
    
    public function saveStand(\Isi\Entity\Article $article, array $values)
    {
        $stand->setName($values['name']);
        $stand->setAddress($values['address']);
        $stand->setCity($values['city']);
        $stand->setState($values['state']);
        $stand->setZipCode($values['zipCode']);

        $this->getEntityManager()->persist($stand);
    }

    public function removeStand($id)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('\NOLASnowball\Entity\Stand', $id);

        $em->remove($proxy);
    }
}

?>
