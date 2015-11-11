<?php

namespace AppBundle\Utility\WebApi\WebResponse;

abstract class WebResponseMode
{
  // protected $restClient;
  protected $container;

  public function __construct( $container )
  {
    $this->container = $container;
  }
  
  abstract function getResponse();

  protected function getDoctrine()
  {
    if (!$this->container->has('doctrine')) {
        throw new \LogicException('The DoctrineBundle is not registered in your application.');
    }

    return $this->container->get('doctrine');
  }
  
  protected function getAbleSkyResponse( $url )
  {
    if (!$this->container->has('ci.restclient')) {
        throw new \LogicException('The Ci/RestClientBundle is not registered in your application.');
    }

    $restClient = $this->container->get('ci.restclient');
    $response = $restClient->get($url);
    
    return $response->getContent();
  }

  protected function saveToDB( $item )
  {
    if ( $item ) {
      $em = $this->getDoctrine()->getManager();
      $em->persist( $item );
      $em->flush();
    }
  }
}
