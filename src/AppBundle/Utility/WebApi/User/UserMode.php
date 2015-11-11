<?php

namespace AppBundle\Utility\WebApi\User;

use AppBundle\Utility\WebUtility\WebAuto;

abstract class UserMode
{
  protected $container;

  public function __construct( $container )
  {
    $this->container = $container;
  }
  
  abstract function getResult();

  protected function getDoctrine()
  {
    if (!$this->container->has('doctrine')) {
        throw new \LogicException('The DoctrineBundle is not registered in your application.');
    }

    return $this->container->get('doctrine');
  }

  protected function buildPayload( $data )
  {
    $retArray = array();
    $retArray['data'] = json_encode( $data );
    
    $timestamp = time() * 1000;
    $retArray['timestamp'] = $timestamp;

    $access_key = WebAuto::ABLE_SKY_KEY;

    $accessToken = md5( $retArray['data'] . "|" . $timestamp . "|" . $access_key );
    $retArray['accessToken'] = $accessToken;

    return $retArray;
  }

  protected function postAbleSkyResponse( $dataArray )
  {
    if (!$this->container->has('ci.restclient')) {
        throw new \LogicException('The Ci/RestClientBundle is not registered in your application.');
    }

    $restClient = $this->container->get('ci.restclient');
    $url = WebAuto::ABLE_SKY_USER_API;

    $payloadArray = $this->buildPayload( $dataArray );
    $tPayload = http_build_query($payloadArray);

    $response = $restClient->post( $url, $tPayload );    
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
