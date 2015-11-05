<?php

namespace AppBundle\Utility\Design;

use Symfony\Component\Config\Definition\Exception\Exception;

class DecorateTest {
  function getWealthFactor() {
    $ret = "";
    // $decorate = new DiamondDecorator( new PollutionDecorator( new Plains() ) );
    // $ret .= $decorate->getWealthFactor();
    $process = new AuthenticateRequest( new StructureRequest ( new LogRequest ( new MainProcess() )));
    $ret = $process->process( new RequestHelper() );
    return $ret;
  }
}

abstract class Tile {
  abstract function getWealthFactor();
}

class Plains extends Tile {
  private $wealthfactor = 2;
  function getWealthFactor() {
    return $this->wealthfactor;
  }
}

class DiamondPlains extends Plains {
  function getWealthFactor() {
    return parent::getWealthFactor() + 2;
  }
}

class PollutedPlains extends Plains {
  function getWealthFactor() {
    return parent::getWealthFactor() - 4;
  }
}

abstract class TileDecorator extends Tile {
  protected $tile;
  function __construct( Tile $tile ) {
    $this->tile = $tile;
  }
}

class DiamondDecorator extends TileDecorator {
  function getWealthFactor() {
    return $this->tile->getWealthFactor() + 2;
  }
}

class PollutionDecorator extends TileDecorator {
  function getWealthFactor() {
    return $this->tile->getWealthFactor() - 4;
  }
}

class RequestHelper{}

abstract class ProcessRequest {
  abstract function process( RequestHelper $req );
}

class MainProcess extends ProcessRequest {
  function process( RequestHelper $req ) {
    return __CLASS__ . ": doing something useful with request</br>";
  }
}

abstract class DecorateProcess extends ProcessRequest {
  protected $processrequest;
  function __construct( ProcessRequest $pr ) {
    $this->processrequest = $pr;
  }
}

class LogRequest extends DecorateProcess {
  function process( RequestHelper $req ) {
    $ret = __CLASS__ . ": logging request</br>";
    $ret .= $this->processrequest->process( $req );
    return $ret;
  }
}

class AuthenticateRequest extends DecorateProcess {
  function process( RequestHelper $req ) {
    $ret = __CLASS__ . ": authenticating request</br>";
    $ret .= $this->processrequest->process( $req );
    return $ret;
  }
}

class StructureRequest extends DecorateProcess {
  function process( RequestHelper $req ) {
    $ret = __CLASS__ . ": structuring request data</br>";
    $ret .= $this->processrequest->process( $req );
    return $ret;
  }
}