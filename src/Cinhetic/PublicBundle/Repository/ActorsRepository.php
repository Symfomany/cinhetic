<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ActorsRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class ActorsRepository extends EntityRepository
{


    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getCount(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p)
                    FROM CinheticPublicBundle:Actors p' 
               );

            return $query->getSingleScalarResult();
    }


}