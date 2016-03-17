<?php

namespace AppBundle\Utility\WebApi\User;

use AppBundle\Utility\WebApi\User\UserMode;
use AppBundle\Utility\WebApi\User\UserApiUtil;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Entity\User;

class Login extends UserMode
{
  private $requestData;
  private $user;
  private $logger;

  public function __construct( $container, $data )
  {
    parent::__construct( $container );
    $this->requestData = $data;
    $this->logger = $this->container->get( 'my_service.logger' );
  }
  
  public function getResult()
  {
   // $result = $this->postAbleSkyResponse( $this->buildPayloadData() );
    // $this->checkResponseValidAndSaveUser( $result );

    // $this->buildPayloadData();
    // $result = $this->saveUserResult();

    // $result = '{"result":{"code": 0}}';

    // $result = array();
    // $result = $this->parseRequestData();

    $result = $this->requestData;

   //$result = array();
    $username= $this->parseRequestData()['username'];
    $password = $this->parseRequestData()['password'];

    //$password =$this->encodePassword($this->parseRequestData()['password']);

    $repository = $this->getDoctrine()
                ->getRepository('AppBundle:User');

    $user = $repository->findOneBy(
        array('username' => $username)
    );
    
    $encodePassword = $this->encodePassword( $user, $password );

 
   // $result = '{"type":"login","username":"xuekaotong09","email":"xuekaotong03@126.com","password":"12345678"}'
   // $result = json_decode('{"type":"login","username":"xuekaotong09","email":"xuekaotong03@126.com","password":"12345678"}');
   //var_dump($result->username);  
   // var_dump( $result);
   // $username = $result->username;
   // $password = $result->password;
    if( $encodePassword == $user->getPassword()){
    
       return '{"result":{"code":0}}';
       
    }else{

      return '{"result":{"code":1}}';
    }

 
   $this->logger->debug( date('Y-m-d H:i:s') );
   $this->logger->debug( $result );

    // 把request中username， password
    // 数据库比较   


    // $result = "{result:{code:0} }";
    // $result = "username";
 
  
  }

  private function buildPayloadData()
  {
    $retArray = array();

    // list( $username, $password, $email ) = $this->parseRequestData();
    $retData = $this->parseRequestData();

   // var_dump( $retData );

    $retArray['type'] = 'login';
    $retArray['orgId'] = WebAuto::ORG_ID;
    $retArray['username'] = $retData['username'];
    $retArray['password'] = $retData['password'];
    // $retArray['newPassword'] = $retData['newPassword'];
    // $retArray['username'] = 'test_webschool_01';
    // $retArray['password'] = 'password1802';
    // $retArray['email'] = 'test_webschool_01@test.com';


    // $this->createUser( $retArray['username'], $retArray['password'], $retArray['email'], $retArray['mobile'] );
    return $retArray;
  }

  private function parseRequestData()
  {
    $retArray = array( 'username' => 'empty', 'password' => 'empty', 'email' => '', 'mobile' => '');
    $jsonObj = json_decode($this->requestData);

    if ( isset($jsonObj->{'username'}) ) $retArray['username'] = $jsonObj->{'username'};
    if ( isset($jsonObj->{'password'}) ) $retArray['password'] = $jsonObj->{'password'};
    // if ( isset($jsonObj->{'email'}) ) $retArray['email'] = $jsonObj->{'email'};
    // if ( isset($jsonObj->{'mobile'}) ) $retArray['mobile'] = $jsonObj->{'mobile'};

    return $retArray;
  }

  private function checkResponseValidAndSaveUser( $result )
  {
    $retJson = json_decode( $result );

    if ( isset( $retJson->{'result'} ) ) {
      if ( isset( $retJson->{'result'}->{'code'} ) ) {
        $code = $retJson->{'result'}->{'code'};
        if ( $code == '0' ) {
          // $this->saveToDB( $this->user );
        }
      }
    }
  }
}
