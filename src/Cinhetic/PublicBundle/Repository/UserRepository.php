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
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }



}