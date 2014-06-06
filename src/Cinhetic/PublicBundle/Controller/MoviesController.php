<?php

namespace Cinhetic\PublicBundle\Controller;

use Cinhetic\PublicBundle\Entity\Medias;
use Cinhetic\PublicBundle\Form\SearchType;
use Doctrine\Common\Collections\ArrayCollection;
use Essence\Essence;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Cinhetic\PublicBundle\Entity\Movies;

use Cinhetic\PublicBundle\Form\MoviesType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class MoviesController
 * @package Cinhetic\PublicBundle\Controller
 */
class MoviesController extends AbstractController
{

    /**
     * @var
     */
    protected $embed;


    /**
     * Constructor
     */
    public function __construct(){
        $this->embed = Essence::instance();
    }


    /**
     * Get card of user
     */
    public function cardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $stars = $session->get('stars', array());

         return $this->render('CinheticPublicBundle:Movies:card.html.twig', array(
            'stars' => isset($stars['products'])? $stars['products'] : array(),
            'total' => $stars['totalht']
        ));

    }

    /**
     * Search Movies in Engine Search
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filters = $em->getFilters();
        $filters->disable('softdeleteable');

        $paginator = $this->get('knp_paginator');
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->findAll();
        $ajax = $request->query->get('ajax');

        if(!$ajax){
            $form = $this->createForm(new SearchType(), null, array(
                'action' => $this->generateUrl('Cinhetic_public_search'),
                'method' => 'POST',
            ));

            $form->handleRequest($request);

            if($form->isValid()){
                        $word = $form->get('search')->getData();

                        //with DQL Repository
                        //$movies = $em->getRepository('CinheticPublicBundle:Movies')->search($word);

                        //Wildcard : With Elastica
                        $finderMovies = $this->container->get('fos_elastica.finder.website.movies');
                        $movies = $finderMovies->find($word);


                        $pagination = $paginator->paginate(
                            $movies,
                            $this->get('request')->query->get('pageone', 1) /*page number*/,
                            5,
                            array('pageParameterName' => 'pageone')
                        );

                        return $this->render('CinheticPublicBundle:Movies:searchpage.html.twig',  array(
                            'form' => $form->createView(),
                            'movies' => $this->paginate($movies,7)
                        ));
            }


            return $this->render('CinheticPublicBundle:Movies:searchpage.html.twig',  array(
                'form' => $form->createView(),
                'movies' => $this->paginate($movies,7)
            ));

        }else{
            $word = $request->query->get('word');
            $finderMovies = $this->container->get('fos_elastica.finder.website.movies');
            $movies = $finderMovies->find($word);

            $results_final = array();
            if (!empty($movies))
                foreach ($movies as $movie)
                    $results_final[] = array(
                        'nom' => $movie->getTitle() ."  " . $movie->getCategory()->getTitle() . "(" . $movie->getAnnee() . ")",
                        'url' => $this->generateUrl('movies_show', array('word' => $word, "id" => $movie->getId()))
                    );

            return new JsonResponse($results_final);
        }
    }

    /**
     * Lists all Movies
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Movies a
            WHERE a.dateRelease <= :now
            AND a.dateDeleted IS NULL
            ORDER BY a.title ASC'
        )->setParameter('now', new \Datetime('midnight'));

        $filters = $em->getFilters();
        $filters->disable('softdeleteable');

        $em = $this->getDoctrine()->getManager();
        $entities_next = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Movies a
            WHERE a.dateRelease >= :now
            AND a.dateDeleted IS NULL
            ORDER BY a.title ASC'
        )->setParameter('now', new \Datetime('midnight'));

        $em = $this->getDoctrine()->getManager();
        $entities_archived = $em->createQuery(
            'SELECT a
            FROM CinheticPublicBundle:Movies a
            WHERE a.dateDeleted IS NOT NULL
            ORDER BY a.title ASC'
        );

        $response = new Response();

        $response = $this->render('CinheticPublicBundle:Movies:index.html.twig', array(
            'entities' => $this->paginate($entities, $request->query->get('display',5)),
            'entities_next' => $this->paginate($entities_next, $request->query->get('display',5)),
            'entities_archived' => $this->paginate($entities_archived, $request->query->get('display',5)),
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;

    }


    /**
     * Get Current Movies
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function currentMoviesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->getCurrentMovies();


        $response = new Response();

        $response = $this->render('CinheticPublicBundle:Movies:current.html.twig', array(
            'entities' => $entities,
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée
        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;

    }

    /**
     * Upload Media
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function uploadAction(Request $request, Movies $id)
    {
       $em = $this->getDoctrine()->getManager();

       $file = $request->files->get('file');
       
       $media = new Medias();
       $media->setFile($file);
       $media->setNature('1');
       $media->setMovies($id);
       $media->upload();

       $em->persist($media);
       $em->flush();
       return new JsonResponse(true);

    }


    /**
     * Get Star Movies entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function starsMoviesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CinheticPublicBundle:Movies')->getStarMovies();

         $response = new Response();

        $response = $this->render('CinheticPublicBundle:Movies:stars.html.twig', array(
            'entities' => $entities,
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée
        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;


    }



    /**
     * Get Star Movies entities.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function carousselMoviesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $imgs = $em->getRepository('CinheticPublicBundle:Movies')->getAllImagesOfMovies();

        return $this->render('CinheticPublicBundle:Movies:caroussel.html.twig', array(
            'imgs' => $imgs,
        ));
    }



    /**
     * Creates a new Movies entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Movies();
        $form = $this->get('cinhetic_public.manager_movies')->createForm($entity);

        if($this->get('cinhetic_public.manager_movies')->validation($form, $entity) == TRUE){
            $this->setMessage("Le film a été crée");
           return $this->redirect($this->generateUrl('movies')); 
        }

        return $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

  

    /**
     * Edits an existing Movies entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function pdfAction(Request $request, Movies $id)
    {
        $pdfObj = $this->get("white_october.tcpdf")->create();
        $type = $request->query->get('type', 'I');
        // set document information
        $pdfObj->SetCreator(PDF_CREATOR);
        $pdfObj->SetAuthor('SymfoAcademy');
        $pdfObj->SetTitle('Profil de film');
        $pdfObj->SetSubject('Profil de film');
        $pdfObj->SetKeywords('Profil de film, SymfoAcademy Solution');

// set default header data
// remove default header/footer
        $pdfObj->setPrintHeader(false);
        $pdfObj->setPrintFooter(false);


// set margins
        $pdfObj->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdfObj->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdfObj->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdfObj->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdfObj->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //$pdfObj->SetFont('/usr/share/fonts/helvetica.ttf', '', 14, '', true);
        //$fontname = $pdfObj->addTTFfont('/path-to-font/DejaVuSans.ttf', 'TrueTypeUnicode', '', 32);
        $pdfObj->AddPage();
// ---------------------------------------------------------

// set default font subsetting mode
        $pdfObj->setFontSubsetting(true);

// set text shadow effect
        $pdfObj->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $barcodeobj = new \TCPDF2DBarcode('http://www.tcpdf.org', 'QRCODE,H');

        // Set some content to print
        $html = $this->renderView('CinheticPublicBundle:Movies:export.html.twig',
         array(
            'entity' => $id,
        ));


// Print text using writeHTMLCell()
        $pdfObj->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
        $path = $this->get('kernel')->getRootDir() . '/../web';

        $pdfObj->Output('movie_pdf.pdf', $type);
    

    }


    /**
     * Edits an existing Movies entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function updateAction(Request $request, Movies $id)
    {
        
        $mediasembed = $this->generateEmbed($id);
        $form = $this->get('cinhetic_public.manager_movies')->editForm($id);

        if($this->get('cinhetic_public.manager_movies')->validation($form, $id) == TRUE){
            $this->setMessage("Le film a été modifié");
           return $this->redirect($this->generateUrl('movies')); 
        }

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $id,
            'mediasembed'      => $mediasembed,
            'form'   => $form->createView(),
        ));

    }

    /**
     * Deletes a Movies entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        $this->get('cinhetic_public.manager_movies')->remove($id);

        return $this->redirect($this->generateUrl('movies'));
    }


    /**
     * Displays a form to create a new Movies entity.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Créer");

        $entity = new Movies();
        $form = $this->get('cinhetic_public.manager_movies')->createForm($entity);

        $response = new Response();

        $response = $this->render('CinheticPublicBundle:Movies:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $date = new \DateTime();
        $date->modify('+600 seconds');

        $response->setExpires($date);
        $response->setETag(md5($response->getContent()));
        $response->setPublic(); // permet de s'assurer que la réponse est publique, et qu'elle peut donc être cachée

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;
    }


    /**
     * Finds and displays a Movies entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function showAction(Movies $id)
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Voir");

        $paybox = $this->get('lexik_paybox.request_handler');
        $paybox->setParameters(array(
            'PBX_CMD'          => 'CMD'.time(),
            'PBX_DEVISE'       => '978',
            'PBX_PORTEUR'      => 'test@paybox.com',
            'PBX_RETOUR'       => 'Mt:M;Ref:R;Auto:A;Erreur:E',
            'PBX_TOTAL'        => $id->getPrice(),
            'PBX_TYPEPAIEMENT' => 'CARTE',
            'PBX_TYPECARTE'    => 'CB',
            'PBX_EFFECTUE'     => $this->generateUrl('lexik_paybox_return', array('status' => 'success'), true),
            'PBX_REFUSE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'denied'), true),
            'PBX_ANNULE'       => $this->generateUrl('lexik_paybox_return', array('status' => 'canceled'), true),
            'PBX_RUF1'         => 'POST',
            'PBX_REPONDRE_A'   => $this->generateUrl('lexik_paybox_ipn', array('time' => time()), true),
        ));


        $deleteForm = $this->createDeleteForm($id);
        $embed = $this->embed->embed($id->getTrailer());

        return $this->render('CinheticPublicBundle:Movies:show.html.twig', array(
            'entity'      => $id,
            'embed'      => $embed,
            'delete_form' => $deleteForm->createView(),
            'url'  => $paybox->getUrl(),
            'form' => $paybox->getForm()->createView()
         ));
    }


    /**
     * displays a Movies medias.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function mediasAction(Movies $id)
    {

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Film ".$id->getTitle(), $this->generateUrl('movies_show', array('id' => $id->getId())));
        $breadcrumbs->addItem("Medias");


        return $this->render('CinheticPublicBundle:Movies:medias.html.twig', array(
            'entity'      => $id,
            'medias'      => $id->getMedias(),
         ));
    }


    /**
     * Displays a form to edit an existing Movies entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function editAction(Movies $id)
    {
         $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Home", $this->get("router")->generate("Cinhetic_public_homepage"));
        $breadcrumbs->addItem("Films", $this->generateUrl('movies'));
        $breadcrumbs->addItem("Editer");
       
        $form = $this->get('cinhetic_public.manager_movies')->editForm($id);
        $mediasembed = $this->generateEmbed($id);

        return $this->render('CinheticPublicBundle:Movies:edit.html.twig', array(
            'entity'      => $id,
            'mediasembed'      => $mediasembed,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Generate Embed videos
     * @param ArrayCollection $medias
     */
    protected function generateEmbed(Movies $entity){
        $medias = $entity->getMedias();
        $mediasembed = array();

        if(!empty($medias))
            foreach($medias as $media){
                if($media->getNature() == 2)
                    $mediasembed[] = $this->embed->embed($media->getVideo());
            }

        return $mediasembed;
    }


    /**
     * add Favoris Videos
     * @param ArrayCollection $medias
     */
    public function favorisAction(Movies $id,Request $request){
        $session = $request->getSession();

        $stars = $session->get('stars', array());
        $flag = false;

        if(!empty($stars)){
            foreach ($stars as $star => $item) { 
                if ($id->getId() == $star) { 
                    $stars['products'][$star]['id'] = $id->getId();
                    $stars['products'][$star]['title'] = $id->getTitle();
                    $stars['products'][$star]['ref'] = $id->getRef();
                    $stars['products'][$star]['price'] = $id->getPrice();
                    $stars['products'][$star]['quantity'] = $item['quantity'] + 1;
                    $stars['products'][$star]['date_created'] = new \Datetime('now');
                    $stars['totalht'] = $stars['totalht'] + $id->getPrice();

                    $flag = true;
                    break; 
                } 
            } 
        }else{
            $stars['totalht'] = 0;
        }

        if($flag != true) {
            $stars['products'][$id->getId()]= array(
                'id' => $id->getId(),
                'title' => $id->getTitle(),
                'ref' => $id->getRef(),
                'price' => $id->getPrice(),
                'quantity' => 1,
                'date_created' => new \Datetime('now')
            );
        }


        $session->set('stars', $stars);
        return new JsonResponse(true);
    }

    /**
     * Get Movies entity in City.
     * @param string $ville
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cityAction($ville= "Paris")
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->getMoviesByCity($ville);
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $movies,
            $this->get('request')->query->get('pageone', 1) /*page number*/,
            5,
            array('pageParameterName' => 'pageone')
        );
        return $this->render('CinheticPublicBundle:Movies:city.html.twig', array(
            'city' => $ville,
            'movies' => $pagination
        ));
    }


    /**
     * Enable Movies entity.
     * @param Movies $id
     * @param int $activation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activationAction(Movies $id, $activation = 1)
    {
        $id->setVisible((bool)$activation);
        $this->processPersist($id);

        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }



    /**
     * Cover Movies entity.
     * @param Movies $id
     * @param $cover
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function coverAction(Movies $id, $cover)
    {
        $id->setCover($cover);
        $this->processPersist($id);

        return $this->redirect($this->generateUrl('Cinhetic_public_homepage'));
    }

    /**
     * Deletes a Movies by link
     * @param Movies $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletelinkAction(Movies $id)
    {
        $this->processRemove($id);
        return $this->redirect($this->generateUrl('movies'));
    }

    /**
     * Creates a form to delete a Movies entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movies_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * Validate a movies
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function archivedAction(Movies $id)
    {

        if($this->get('cinhetic_public.manager_movies')->delete($id) == true){
            return new JsonResponse(true);
        }

        return new JsonResponse(false);
    }

    /************************************************************************************************************
     ***************************************************************** API Override Call ********************************************
     *************************************************************************************************************/

    /**
     * @Rest\View
     * Return All Movies
     */
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository('CinheticPublicBundle:Movies')->findAll();

        return array('movies' => $movies);
    }

    /**
     * @Rest\View
     * Return one Movie
     */
    public function oneAction(Movies $id)
    {
        return array('movie' => $id);
    }


}
