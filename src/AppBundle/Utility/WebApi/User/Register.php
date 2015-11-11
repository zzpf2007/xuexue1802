<?php

namespace AppBundle\Utility\WebApi\User;

use AppBundle\Utility\WebApi\User\UserMode;
use AppBundle\Utility\WebApi\User\UserApiUtil;
use AppBundle\Utility\WebUtility\WebAuto;

class Register extends UserMode
{
  private $requestData;
  public function __construct( $container, $data )
  {
    parent::__construct( $container );
    $this->requestData = $data;
  }
  
  public function getResult()
  {
    $result = $this->postAbleSkyResponse( $this->buildPayloadData() );
    return $result;
  }

  private function buildPayloadData()
  {
    $retArray = array();

    // list( $username, $password, $email ) = $this->parseRequestData();
    $retData = $this->parseRequestData();

    $retArray['type'] = 'register';
    $retArray['orgId'] = WebAuto::ORG_ID;
    $retArray['username'] = $retData['username'];
    $retArray['password'] = $retData['password'];
    $retArray['email'] = $retData['email'];
    // $retArray['username'] = 'test_webschool_01';
    // $retArray['password'] = 'password1802';
    // $retArray['email'] = 'test_webschool_01@test.com';
    return $retArray;
  }

  private function parseRequestData()
  {
    $retArray = array( 'username' => 'empty', 'password' => 'empty', 'email' => 'empty');
    $jsonObj = json_decode($this->requestData);

    if ( isset($jsonObj->{'username'}) ) $retArray['username'] = $jsonObj->{'username'};
    if ( isset($jsonObj->{'password'}) ) $retArray['password'] = $jsonObj->{'password'};
    if ( isset($jsonObj->{'email'}) ) $retArray['email'] = $jsonObj->{'email'};

    return $retArray;
  }
}
