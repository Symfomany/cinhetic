<?php
namespace Cinhetic\PublicBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class MoviesRepository
 * @package Cinhetic\PublicBundle\Repository
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
                FROM CinheticPublicBundle:Movies p
                JOIN p.category ca
                JOIN p.tags ta
                JOIN p.cinemas ci
                JOIN p.directors di
                JOIN p.actors ac

                WHERE (p.title LIKE :article
                OR ca.title LIKE :category
                OR ta.word LIKE :tag
                OR ci.title LIKE :cinema
                OR di.firstname LIKE :difirstname
                OR di.lastname LIKE :dilastname
                OR ac.firstname LIKE :acfirstname
                OR ac.lastname LIKE :aclastname)
                AND p.visible = 1
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
     * @return array
     */
    public function getRandomMovie(){

 $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Cinhetic\PublicBundle\Entity\Movies', 'm')
            ->where('m.visible = 1')
            ->andWhere('m.dateRelease <= :current')
            ->orderBy('RAND()', 'DESC')
            ->setParameter('current' , new \Datetime('midnight'))
            ->setMaxResults(1);

            return $query;
    }


    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getStatsMoviesCategories(){

        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT COUNT(m.id) as nbmovies, c.title
                    FROM CinheticPublicBundle:Categories c
                    JOIN c.movies m
                    GROUP BY c.id
                    ORDER BY nbmovies DESC"
            );

            return $query->setMaxResults(5)->getScalarResult();
    }

    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getCount(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p)
                    FROM CinheticPublicBundle:Movies p'
            );

            return $query->getSingleScalarResult();
    }

    /**
     * Get Current movies by criteria
     * @return array
     */
    public function getCurrentMovies(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.dateRelease >= :current
                    AND p.visible = 1
                    ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));

            return $query->getResult();
    }


    /**
     * Get images of movies
     * @return array
     */
    public function getAllImagesOfMovies(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.visible = 1
                    AND p.image IS NOT NULL
                    ORDER BY p.id DESC'
            );

            return $query->getResult();
    }


    /**
     * Get Current movies by criteria
     * @param string $ville
     * @return array
     */
    public function getMoviesByCity($ville = ""){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    JOIN p.cinemas c
                    WHERE p.dateRelease >= :current
                    AND p.visible = 1
                    AND c.ville LIKE :ville
                    ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
                'ville' => $ville,
            ));

            return $query->getResult();
    }


    /**
     * Get Active Movies
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveMoviesBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Cinhetic\PublicBundle\Entity\Movies', 'm')
            ->where('m.visible = 1')
            ->andWhere('m.dateRelease <= :current')
            ->orderBy('m.id', 'DESC')
            ->setParameter('current' , new \Datetime('midnight'));


        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get Active movies by criteria
     * @return array
     */
    public function getActiveMovies(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM CinheticPublicBundle:Movies p
                WHERE p.dateRelease >= :current
                AND p.visible = 1
                ORDER BY p.title ASC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));


            return $query;
    }

    /**
     * Get Number of Movies
     */
    public function getNbMovies(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Movies p'
            );

        return $query->getSingleScalarResult();

    }

    /**
     * Get Ratio of Active Movies
     */
    public function getRatioActiveMovies($visible = 1){

        $nb = $this->getNbMovies();

        $nb_criteria = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.visible = :visible'
            )->setParameter('visible', $visible)->getSingleScalarResult();

        return floor(((float)$nb_criteria * 100) / (float)$nb);
    }

    /**
     * Get Ratio of Active Movies
     */
    public function getRatioActusMovies(){

        $nb = $this->getNbMovies();

        $nb_criteria = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.dateRelease >= :now'
            )->setParameter('now', new \Datetime('now'))->getSingleScalarResult();

        return floor(((float)$nb_criteria * 100) / (float)$nb);
    }

    /**
     * Get Ratio of Active Movies
     */
    public function getRatioCoverMovies($cover = 1){

        $nb = $this->getNbMovies();

        $nb_criteria = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.cover = :cover'
            )->setParameter('cover', $cover)->getSingleScalarResult();

        return floor(((float)$nb_criteria * 100) / (float)$nb);
    }

    /**
     * Get all Movies order by date release
     * @param integer $limit
     * @return array
     */
    public function getAllMovies($limit = 10){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    ORDER BY p.dateRelease DESC'
            );
            return $query->setMaxResults($limit)->getResult();
    }

    /**
     * Get current movies with limit
     * @param integer $limit
     * @return array
     */
    public function getCoverMovies($limit = 5){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT m
                    FROM CinheticPublicBundle:Medias m
                    JOIN m.movies mo
                    WHERE mo.dateRelease <= :current
                    AND mo.visible = 1
                    AND mo.cover = 1
                    ORDER BY mo.id DESC'
            )
            ->setParameters(
            array(
                'current' => new \Datetime('midnight'),
            ));

            return $query->setMaxResults($limit)->getResult();
    }


    /**
     * Get movies stars
     * @param integer $limit
     * @return array
     */
    public function getStarMovies($limit = 3){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p
                    FROM CinheticPublicBundle:Movies p
                    WHERE p.visible = 1
                    ORDER BY p.notePresse DESC'
            );

            return $query->setMaxResults($limit)->getResult();
    }


}