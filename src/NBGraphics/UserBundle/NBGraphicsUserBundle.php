<?php

namespace NBGraphics\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NBGraphicsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
