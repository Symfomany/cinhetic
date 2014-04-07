<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class VillesRepository
 * @package Horus\AdminBundle\Repository
 */
class VillesRepository extends EntityRepository
{

    /**
     * Get Active Receipt
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveVillesQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Cinhetic\PublicBundle\Entity\Villes', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }



}