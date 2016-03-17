<?php

namespace AppBundle\Utility\WebApi\User;

class UserApiFactory
{
  private function __construct() { }

  static function getInstance( $name, $data = null, $container) 
  {
    $apiObject;
    switch ( $name ) {
      case ( 'register' ):
        $apiObject = new Register($container, $data); break;

      case ( 'changePwd' ):
        $apiObject = new ChangePwd($container, $data); break;

      case ( 'changePhoto' ):
        $apiObject = new ChangePhoto($container, $data); break;

      case ( 'changeName' ):
        $apiObject = new ChangeName($container, $data); break;

      case ( 'login' ):
        $apiObject = new Login($container, $data); break;
        
      default:
        $apiObject = new UserDefault($container);        
    }
    return $apiObject;
  }
}

class UserDefault extends UserMode 
{
  function getResult() 
  {
    return "Default empty result!";
  }
}