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
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM EzapPublicBundle:Movies p
                JOIN p.category ca
                JOIN p.tags ta
                JOIN p.cinemas ci
                JOIN p.directors di
                JOIN p.actors ac

                WHERE p.title LIKE :article
                OR ca.title LIKE :category
                OR ta.word LIKE :tag
                OR ci.title LIKE :cinema
                OR di.firstname LIKE :difirstname
                OR di.lastname LIKE :dilastname
                OR ac.firstname LIKE :acfirstname
                OR ac.lastname LIKE :aclastname
                ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'article' => "%".$word."%",
                'category' => "%".$word."%",
                'tag' => "%".$word."%",
                'cinema' => "%".$word."%",
                'difirstname' => "%".$word."%",
                'dilastname' => "%".$word."%",
                'acfirstname' => "%".$word."%",
                'aclastname' => "%".$word."%",
            ));

            return $query->getResult();
    }

    /**
     * Get Current movies by criteria
     * @param null $word
     * @return array
     */
    public function getCurrentMovies($limit = 3){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM EzapPublicBundle:Movies p
                    WHERE p.dateRelease >= :current
                    ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));

            return $query->setMaxResults($limit)->getResult();
    }


    /**
     * Get  movies more scored
     * @param null $word
     * @return array
     */
    public function getStarMovies($limit = 3){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM EzapPublicBundle:Movies p
                    ORDER BY p.notePresse DESC'
            );

            return $query->setMaxResults($limit)->getResult();
    }


}