<?php

namespace AppBundle\Utility\WebApi;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebApi\WebApiCategory;

class WebApiFactory {
  private function __construct() {
  }

  static function getInstance( $name, $container, $itemId ) {
    $webApiObject;
    switch ( $name ) {
      case ( 'course' ):
        $webApiObject = new WebApiCourse($container, $itemId); break;
      case ( 'category' ):
        $webApiObject = new WebApiCategory($container, $itemId); break;
      default:
        $webApiObject = new WebApiDefault($container);        
    }
    return $webApiObject;
  }
}

class WebApiDefault extends WebApiMode {
  function getResult() {
    return "Default empty result!";
  }
}
