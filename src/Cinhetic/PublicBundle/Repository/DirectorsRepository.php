<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class DirectorsRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class DirectorsRepository extends EntityRepository
{



    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getCount(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p)
                    FROM CinheticPublicBundle:Directors p' 
               );

            return $query->getSingleScalarResult();
    }


}