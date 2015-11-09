<?php

namespace AppBundle\Utility\WebApi;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebApi\WebApiCategory;

class WebApiFactory {
  private function __construct() {
  }

  static function getInstance( $name, $container, $itemId ) {
    switch ( $name ) {
      case ( 'course' ):
        return new WebApiCourse($container, $itemId);
      default:
        return new WebApiDefault($container);
    }
  }
}

class WebApiDefault extends WebApiMode {
  function getResult() {
    return "Default empty result!";
  }
}
