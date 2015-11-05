<?php

namespace AppBundle\Utility\Design;

use AppBundle\Utility\Design\DesignMode;

class StrategyTest extends DesignMode {
  function runTest() {
    $ret = "";
    $marker = new RegexpMarker('/f.ve/');
    $question = new TextQuestion( 'This is Question!', $marker );
    $response = 'five';
    $ret = $question->mark( $response );
    return $ret;
  }
}

abstract class Question {
  protected $prompt;
  protected $marker;

  function __construct( $prompt, Marker $marker ) {
    $this->prompt = $prompt;
    $this->marker = $marker;
  }

  function mark( $response ) {
    return $this->marker->mark( $response );
  }
}

class TextQuestion extends Question {

}

class AVQuestion extends Question {

}

abstract class Marker {
  protected $test;

  function __construct( $test ) {
    $this->test = $test;
  }

  abstract function mark( $response );
}

class MarkLogicMarker extends Marker {
  private $engine;
  function __construct( $test ) {
    parent::__construct( $test );
    // $this->engine = new MarkParse( $test );
  }

  function mark( $response ) {
    // return $this->engine->evaluate( $response );
    return true;
  }
}

class MatchMarker extends Marker {
  function mark( $response ) {
    return ( $this->test == $response );
  }
}

class RegexpMarker extends Marker {
  function mark( $response ) {
    return ( preg_match( $this->test, $response ));
  }
}