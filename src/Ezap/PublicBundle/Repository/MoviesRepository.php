<?php
namespace Ezap\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class MoviesRepository
 * @package Horus\AdminBundle\Repository
 */
class MoviesRepository extends EntityRepository
{

    /**
     * Search all movies by criteria
     * @param null $word
     * @return array
     */
    public function search($word = null){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM EzapPublicBundle:Movies p
                JOIN p.categories
                JOIN p.tags
                JOIN p.cinemas
                JOIN p.directors
                JOIN p.actors
                WHERE (p.title = :article OR c.title = :category)
                ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'article' => $word,
                'category' => $word
            ))
            ->getResult();
    }


}