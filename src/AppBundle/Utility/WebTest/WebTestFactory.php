<?php

namespace AppBundle\Utility\WebTest;
use AppBundle\Utility\RunTestMode;
use AppBundle\Utility\WebTest\WebResponseTest;

class WebTestFactory {
  private function __construct() {
  }

  static function getInstance( $name, $restClient ) {
    switch ( $name ) {
      case ( 'response' ):
        return new WebResponseTest($restClient);
      default:
        return new WebTestDefault($restClient);
    }
  }
}

class WebTestDefault extends RunTestMode {
  function runTest() {
    return "Default class: runTest();";
  }
}
