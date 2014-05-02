<?php

namespace Cinhetic\PublicBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Cinhetic\PublicBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class ActivityListener
 * @package Cinhetic\PublicBundle\Listener
 */
class ActivityListener
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $context;
    /**
     * @var object
     */
    protected $em;
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     * @param SecurityContext $context
     * @param EntityManager $em
     */
    public function __construct(SecurityContext $context, EntityManager $em)
    {
        $this->context = $context;
        $this->em = $em;
    }

    /**
     * Update the user "lastActivity" on each request
     * @param FilterControllerEvent $event
     */
    public function onCoreController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        if ($this->context->getToken()) {
            $user = $this->context->getToken()->getUser();
            $delay = new \DateTime();
            $delay->setTimestamp(strtotime('5 minutes ago'));

            if ($user instanceof User && $user->getLastActivity() < $delay) {
                $user->isActiveNow();
                $this->em->flush($user);
            }

        }
    }


}


