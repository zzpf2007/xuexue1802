<?php

namespace Acme\Bundle\WebUIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction($name)
    {
      $name = $this->getParameter('web_ui.homepage.titlebar')['title'];
      return array('name' => $name);
    }
}
