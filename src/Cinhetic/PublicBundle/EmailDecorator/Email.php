<?php

namespace Cinhetic\PublicBundle\EmailDecorator;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Email
 * Email Class Service
 * @package Cinhetic\PublicBundle\Email
 */
class Email {

    protected $container;
    protected $administrateur;
    protected $base_url;
    protected $base_img;
    protected $key;
    protected $route;
    protected $datas;
    protected $params;
    protected $configuration;

    /**
     * Constructor with Container
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->administrateur = $this->container->getParameter('email_administrateur');
        $this->base_url = $this->container->getParameter('url_base');
        $this->base_img = $this->base_url . '/bundles/cinhetic/email/img/';
        $this->key = $this->container->getParameter('key_autoloading');
        $this->datas = array();
    }

    /**
     *  Send E-Mail
     * @param type $user
     * @param type $templating
     */
    public function send($user = null, $templating = null,$subject = "Email de Cinhetic Project", $to = null, $key = null, $datas = array(), $contentType = 'text/html', $base_url = 'http://94.23.5.209/web/', $sender = null,  $level = 0) {

        $this->base_url = $base_url;

        $etats = array("Bas", "Normal", "Haut", "Urgent", "Immédiat");
        // Initialisation
        if(empty($sender))
            $sender = array($this->container->getParameter('email_membre') => 'Horus');

        // Initialisation
        if(!empty($key))
            $this->key = $key;
        if(!empty($datas))
            $this->datas = $datas;

        // Sending Email
        $message = \Swift_Message::newInstance()
            ->setSubject("[Priorité = ".$etats[$level]."] ".$subject)
            ->setTo($to)
            ->setFrom($sender)
            ->setContentType('text/html')
            ->setBody($this->container->get('templating')->render($templating, array(
                'user' => $user,
                'datas' => $this->datas,
                'base_img' => $this->base_img,
                'base_url' => $this->base_url,
                'sujet' => $subject,
                'configuration' => $this->configuration,
            )));

        $this->container->get('mailer')->send($message);
        return true;
    }

}

?>