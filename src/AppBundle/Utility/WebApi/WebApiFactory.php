<?php

namespace AppBundle\Utility\WebApi;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebApi\WebApiCategory;

class WebApiFactory {
  private function __construct() {
  }

  static function getInstance( $name, $restClient ) {
    switch ( $name ) {
      case ( 'categories' ):
        return new WebApiCategory($restClient);
      default:
        return new WebApiDefault($restClient);
    }
  }
}

class WebApiDefault extends WebApiMode {
  function getResult() {
    return "Default class: getResult();";
  }
}
