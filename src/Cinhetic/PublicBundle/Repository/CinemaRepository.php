<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CinemaRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class CinemaRepository extends EntityRepository
{

    /**
     * Get Active Receipt
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCitiesOfMovies()
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Cinema p
                    GROUP BY p.ville
                    ORDER BY p.ville ASC'
            );
        return $query->getResult();
    }

}