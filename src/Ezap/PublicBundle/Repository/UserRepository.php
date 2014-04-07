<?php
namespace Ezap\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package Horus\AdminBundle\Repository
 */
class UserRepository extends EntityRepository
{

    /**
     * Get Active Receipt
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveUserQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Ezap\PublicBundle\Entity\User', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }



}