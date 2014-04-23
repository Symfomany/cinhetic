<?php

namespace Cinhetic\PublicBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CinheticPublicBundle
 * @package Cinhetic\PublicBundle
 */
class CinheticPublicBundle extends Bundle
{

    /**
     * Get Parent of Bundle
     * @return string
     */
    public function getParent()
    {

        return 'FOSUserBundle';
    }

}
