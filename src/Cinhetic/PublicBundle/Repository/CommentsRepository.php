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


    /**
     * Get Number of Comments
     */
    public function getNbComment(){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Comments p'
            );


        return (int)array_shift($query->getOneOrNullResult());

    }

    /**
     * Get Number of Comments From Criteria
     */
    public function getNbCommentInState($state = 2){
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(p.id)
                    FROM CinheticPublicBundle:Comments p
                    WHERE p.state = :state'
            )->setParameter('state', $state);

        return (int)array_shift($query->getOneOrNullResult());

    }

    /**
     * Get Ratio of Active Comments
     */
    public function getRatioActiveComment($state = 2){

        $nb = $this->getNbComment();

        $nb_criteria = $this->getNbCommentInState($state);

        return ((int)$nb > 0) ? floor((float)$nb_criteria * 100 / (float)$nb) : 0;
    }



}