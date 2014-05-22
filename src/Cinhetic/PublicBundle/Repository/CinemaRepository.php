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
     * Get Cities of Movies Cinemas
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


    /**
     * Get Number of Movies
     */
    public function getNbCinemas(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Cinema p'
            );

        return (int)array_shift($query->getOneOrNullResult());
    }

    /**
     * Get Cinemas has seance
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getRatioHasSeance(\Datetime $date)
    {
        $nb = $this->getNbCinemas();

        $nb_criteria = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(c.id)
                    FROM CinheticPublicBundle:Sessions s
                    JOIN s.cinema c
                    WHERE s.dateSession >= :date
                    GROUP BY c.id'
            )->setParameter('date', $date)->getResult();


        return ((int)$nb > 0) ? floor((float)$nb_criteria * 100 / (float)$nb) : 0;


    }



    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getCount(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p)
                    FROM CinheticPublicBundle:Cinema p' 
               );

        return (int)array_shift($query->getOneOrNullResult());
    }

}