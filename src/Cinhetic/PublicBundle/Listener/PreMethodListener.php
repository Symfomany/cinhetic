<?php

namespace Cinhetic\PublicBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
/**
 * Class PreMethodListener
 * @package Cinhetic\PublicBundle\Listener
 */
class PreMethodListener
{
    /**
     * Executue a preExecute method like Symfony1
     * @param FilterControllerEvent $event
     */
    public function onCoreController(FilterControllerEvent $event) {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            $_controller = $event->getController();
            if (isset($_controller[0])) {
                $controller = $_controller[0];
                if (method_exists($controller, 'preExecute')) {
                    $controller->preExecute();
                }
            }
        }
    }


}