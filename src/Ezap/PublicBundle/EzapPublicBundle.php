<?php

namespace Ezap\PublicBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EzapPublicBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
