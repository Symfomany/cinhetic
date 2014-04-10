<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SessionsRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class SessionsRepository extends EntityRepository
{

    /**
     * Get All Movies order by date realase desc
     * @param null $limit
     * @return array
     */
    public function getNextSessions($limit = 5){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Sessions p
                    WHERE p.dateSession >= :current
                    GROUP BY p.cinema
                    ORDER BY p.dateSession DESC'
            )->setParameters(
                array(
                    'current' => new \Datetime('now'),
                ));
        return $query->setMaxResults($limit)->getResult();
    }


}