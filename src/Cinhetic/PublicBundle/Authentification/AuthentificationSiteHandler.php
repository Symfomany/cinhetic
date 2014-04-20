<?php

namespace  Cinhetic\PublicBundle\Authentification;

use Symfony\Component\Routing\RouterInterface,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Symfony\Component\HttpFoundation\Request,
    Doctrine\ORM\EntityManager,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface,
    Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AuthenticationSiteHandler
 * @package Cinhetic\PublicBundle\Authentication
 */
class AuthentificationSiteHandler implements  AuthenticationSuccessHandlerInterface{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Constructor Dependances
     * @param RouterInterface $router
     * @param EntityManager $em
     * @param Session $session
     */
    public function __construct(ContainerInterface $container) {

        $this->container = $container;
    }

    /**
     * Method Authentification Sucess
     * @param Request $request
     * @param TokenInterface $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        $user = $token->getUser();

        $referer = $this->container->get('router')->generate('Cinhetic_public_homepage');

        //send email notification
        $message = \Swift_Message::newInstance()
            ->setSubject('Connexion à Cinhetic Project')
            ->setFrom('julien@meetserious.com')
            ->setTo($user->getEmail())
            ->setContentType("text/html")
            ->setBody($this->container->get('templating')->render('CinheticPublicBundle:Email:connexion.html.twig', array('email' => $user->getEmail())));
        $this->container->get('mailer')->send($message);

        if($referer == 'http://'.$request->getHttpHost().'/login')
            $referer = $this->container->get('router')->generate('Cinhetic_public_homepage');

        return new RedirectResponse($referer);
    }

}


?>