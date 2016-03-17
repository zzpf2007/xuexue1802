<?php
namespace AppBundle\Utility\WebApi\User;
use AppBundle\Utility\WebApi\User\UserMode;
use AppBundle\Utility\WebApi\User\UserApiUtil;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Entity\User;
use AppBundle\Entity\Account;

class ChangePhoto extends UserMode
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
    $result = $this->postAbleSkyResponse( $this->buildPayloadData() );
    // $this->checkResponseValidAndSaveUser( $result );
    $this->buildPayloadData();
    $result = $this->saveUserResult();

    $this->logger->debug( date('Y-m-d H:i:s') );
    $this->logger->debug( $result );


    return $result;
  }


  private function buildPayloadData()
  {
    $retArray = array();
    // list( $username, $password, $email ) = $this->parseRequestData();
    $retData = $this->parseRequestData();
    // var_dump( $retData );
    $retArray['type'] = 'changePhoto';
    $retArray['orgId'] = WebAuto::ORG_ID;
    $retArray['username'] = $retData['username'];
    $retArray['photo'] = $retData['photo'];
    $retArray['newPhoto'] = $retData['newPhoto'];
    //$retArray['password'] = $retData['password'];
    //$retArray['newPassword'] = $retData['newPassword'];
    // $retArray['username'] = 'test_webschool_01';
    // $retArray['password'] = 'password1802';
    // $retArray['email'] = 'test_webschool_01@test.com';
    // $this->createUser( $retArray['username'], $retArray['password'], $retArray['email'], $retArray['mobile'] );
    return $retArray;
  }

  private function parseRequestData()
  {
    $retArray = array( 'username' => 'empty', 'password' => 'empty', 'email' => '', 'mobile' => '','photo'=> '');
    $jsonObj = json_decode($this->requestData);
    if ( isset($jsonObj->{'username'}) ) $retArray['username'] = $jsonObj->{'username'};
    if ( isset($jsonObj->{'photo'}) ) $retArray['photo'] = $jsonObj->{'photo'};
    if ( isset($jsonObj->{'newPhoto'}) ) $retArray['newPhoto'] = $jsonObj->{'newPhoto'};
   //if ( isset($jsonObj->{'password'}) ) $retArray['password'] = $jsonObj->{'password'};
    //if ( isset($jsonObj->{'newPassword'}) ) $retArray['newPassword'] = $jsonObj->{'newPassword'};
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
   private function saveUserResult()
  {

    $username= $this->parseRequestData()['username'];
    $photo= $this->parseRequestData()['photo'];
    $newPhoto= $this->parseRequestData()['newPhoto'];
   
    $repository = $this->getDoctrine()
               ->getRepository('AppBundle:User');

    $user = $repository->findOneBy(
        array('username' => $username)
    );
    
    $account = $user->getAccount();

    $this->saveToDB( $account->setPhoto($newPhoto));

    return $this->buildSuccessResponse();
    // return '{ "result" : { "message" : "succeed!", "code" : "0" }  }';
    // return sprintf( 'message: %s', $this->user->getEmail() );    
  }
}