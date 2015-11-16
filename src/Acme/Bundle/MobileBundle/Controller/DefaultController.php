<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/testurl")
     */
    public function testAction()
    {
      $apiMobile = $this->get('my_service.api.mobile.factory')->getInstance( $this->container, 'teachers', null );
      $content = $apiMobile->getResponse();

      return new Response(" Content: </br> " . $content );
    }
}
