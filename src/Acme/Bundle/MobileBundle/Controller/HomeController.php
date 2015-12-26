<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
  /**
   * @Route("/home/{name}/{itemId}", defaults = {"name" = null, "itemId" = null}))
   */
  public function indexAction($name, $itemId)
  {
    $apiMobile = $this->get('my_service.api.mobile.factory')->getInstance( $this->container, $name, $itemId );
    $content = $apiMobile->getResponse();

    return new Response( $content );
 }

  /**
   * @Route("/cmd/run")
   */
  public function cmdAction()
  {
    $name = "teachers";
    $apiMobile = $this->get('my_service.api.mobile.factory')->getInstance( $this->container, $name );
    $content = $apiMobile->update();

    return new Response( $content );
 }
}