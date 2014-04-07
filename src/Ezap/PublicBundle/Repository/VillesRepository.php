<?php
namespace Ezap\PublicBundle\Repository;

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
            ->from('Ezap\PublicBundle\Entity\Villes', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }



}