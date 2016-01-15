<?php

namespace Acme\Bundle\WebUIBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeWebUIBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
