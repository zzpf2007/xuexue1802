<?php

namespace AppBundle\Utility\WebApi\User;

use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Entity\User;
use AppBundle\Entity\Account;

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
    //print $retArray['data'];

    list( $timestamp, $accessToken ) = $this->getTimestampAccessToken( $retArray['data'] );
    
    $retArray['timestamp'] = $timestamp;
    $retArray['accessToken'] = $accessToken;

    return $retArray;
  }

  protected function buildSuccessResponse()
  {
    $retArray = '';
    // $succArray = array( 'code' => 0, 'message' => '请求成功' );
    // $dataString = json_encode( $succArray, JSON_UNESCAPED_UNICODE );
    $dataString = '{ "message":"请求成功", "code":0 }';
    // $retArray['result'] = $dataString;

    list( $timestamp, $accessToken ) = $this->getTimestampAccessToken( $dataString );
    
    $retArray['timestamp'] = $timestamp;
    $retArray['accessToken'] = $accessToken;

    // return json_encode( $retArray );

   return sprintf('{ "result": %s}', $dataString);

   //return sprintf("{ result: %s, timestamp: %s, accessToken: %s}", $dataString, $timestamp, $accessToken);
    // return '{"result":' . $dataString . ', "timestamp":' . $timestamp . ', "accessToken":' . $accessToken . '}';
  }

  protected function getTimestampAccessToken ( $dataString )
  {
    $timestamp = time() * 1000;
    $accessKey = WebAuto::ABLE_SKY_KEY;

    $accessToken = md5( $dataString . "|" . $timestamp . "|" . $accessKey );
    return array( $timestamp, $accessToken );
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

  protected function encodePassword(User $user, $plainPassword)
  {
    $encoder = $this->container->get('security.encoder_factory')
        ->getEncoder($user)
    ;
    return $encoder->encodePassword($plainPassword, $user->getSalt());
  }
}
