<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
      // $url = $this->container->getParameter('api_school.urls')['ABLE_SKY_URL'];
      
      // $url = $this->container->getParameter('ci.restclient.curl.defaults')[CURLOPT_HTTPHEADER];

      $apiMobiel = $this->get('my_service.api.mobile');
      $url = $apiMobiel->getUrl();
      return array('name' => $name, 'url' => $url);
    }
}
