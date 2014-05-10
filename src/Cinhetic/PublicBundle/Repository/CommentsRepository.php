<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommentsRepository
 * @package Cinhetic\PublicBundle\Repository
 */
class CommentsRepository extends EntityRepository
{

    /**
     * Get Current comments by criteria
     * @return array
     */
    public function getAllComments(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Comments p
                    ORDER BY p.id DESC'
            );

            return $query->getResult();
    }



}