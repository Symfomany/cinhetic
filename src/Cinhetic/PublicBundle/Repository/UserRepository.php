<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class UserRepository extends EntityRepository
{

    /**
     * Get Active User
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveUserQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Cinhetic\PublicBundle\Entity\User', 'm')
            ->where('m.enabled', '1')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }

    /**
     * Get Number of Actors
     */
    public function getNbActors(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:User p'
            );

        return $query->getSingleScalarResult();

    }

    /**
     * Get Ratio of Active Actors
     */
    public function getRatioActiveActors($visible = 1){

        $nb = $this->getNbActors();

        $nb_criteria = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:User p
                    WHERE p.enabled = :enabled'
            )->setParameter('enabled', $visible)->getSingleScalarResult();

        return floor(((float)$nb_criteria * 100) / (float)$nb);
    }


}