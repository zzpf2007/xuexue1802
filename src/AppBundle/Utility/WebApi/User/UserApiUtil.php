<?php

namespace AppBundle\Utility\WebApi\User;

class UserApiUtil
{
  private function __construct() { }

  public static function buildRequest( $request )
  {
    $retArray = array();
    $requestType = "";
    $requestData = "";

    if ( $request ) {
      $data = $request->get('data');
      if ( $data ) {
        $requestJson = json_decode( $data );

        if ( isset( $requestJson->{'type'} ) ) {
          $requestType = $requestJson->{'type'};    
        }

        $requestData = $data;
      }
    }

    $retArray[] = $requestType;
    $retArray[] = $data;

    return $retArray;
  }
}