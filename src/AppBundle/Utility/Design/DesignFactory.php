<?php

namespace AppBundle\Utility\Design;
use AppBundle\Utility\Design\DesignMode;
use AppBundle\Utility\Design\ExpressionTest;
use AppBundle\Utility\Design\CompositeTest;
use AppBundle\Utility\Design\StrategyTest;

class DesignFactory {
  private function __construct() {

  }

  static function getInstance( $name ) {
    switch ( $name ) {
      case ( 'expression' ):
        return new ExpressionTest();
      case ('composite'):
        return new CompositeTest();
      case ('strategy'):
        return new StrategyTest();
      case ('observer'):
        return new ObserverTest();
      default:
        return new DesignDefault();
    }
  }
}

class DesignDefault extends DesignMode {
  function runTest() {
    return "Default class: runTest();";
  }
}
