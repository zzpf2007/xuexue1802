<?php

namespace AppBundle\Utility\Design;

use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Utility\Design\DesignMode;

class CompositeTest extends DesignMode {
  function runTest() {
    $ret = $this->getBombardStrength();
    return $ret;
  }

  function getBombardStrength() {
    $army = new Army();
    $army->addUnit(new Archer());
    $army->addUnit(new Archer());
    $army->addUnit(new LaserCannonUnit());
    $army->addUnit(new LaserCannonUnit());

    $army2 = new Army();
    $army2->addUnit($army);
    $archer = new Archer();
    $army2->addUnit($archer);
    $laserCannon = new LaserCannonUnit();
    // $army2->removeUnit($army);

    // $archer->addUnit($army2);

    $unit03 = UnitScript::joinExisting($archer, $laserCannon);
    return $unit03->bombardStrength();
  }
}

class Army extends CompositeUnit {  
}

class Army01 extends Unit{
  private $_units = array();

  function addUnit( Unit $unit ) {
    if ( in_array( $unit, $this->_units, true ) ) {
      return;
    }
    $this->_units[] = $unit;
  }

  function removeUnit( Unit $unit ) {
    $this->_units = array_udiff( $this->_units, array( $unit ),
      function( $a, $b ) { return ($a === $b) ? 0 : 1;} );
  }

  function bombardStrength() {
    $ret = 0;
    foreach ($this->_units as $unit) {
      $ret += $unit->bombardStrength();
    }
    return $ret;
  }
}

abstract class Unit01 {
  function addUnit( Unit $unit ) {
    throw new UnitException( get_class($this) . " is a leaf" );
  }

  function removeUnit( Unit $unit ) {
    throw new UnitException( get_class($this) . " is a leaf" );
  }

  abstract function bombardStrength();
}

abstract class Unit {
  function getComposite() {
    return null;
  }

  abstract function bombardStrength();
}

class Archer extends Unit {
  function bombardStrength() {
    return 4;
  }
}

class LaserCannonUnit extends Unit {
  function bombardStrength() {
    return 44;
  }
}

class UnitException extends Exception {}

abstract class CompositeUnit extends Unit {
  private $_units = array();

  function getComposite() {
    return $this;
  }

  protected function units() {
    return $this->_units;
  }

  function removeUnit( Unit $unit ) {
    $this->units = array_udiff( $this->_units, array( $unit ),
        function( $a, $b ) { return ($a === $b) ? 0 : 1;} );
  }

  function addUnit( Unit $unit ) {
    if ( in_array( $unit, $this->_units, true )) {
      return;
    }
    $this->_units[] = $unit;
  }

  function bombardStrength() {
    $ret = 0;
    foreach ($this->_units as $unit) {
      $ret += $unit->bombardStrength();
    }
    return $ret;
  }
}

class UnitScript {
  static function joinExisting( Unit $newUnit, Unit $occupyingUnit ) {
    $comp;

    if ( !is_null( $comp = $occupyingUnit->getComposite() )) {
      $comp->addUnit( $newUnit );
    } else {
      $comp = new Army();
      $comp->addUnit( $occupyingUnit );
      $comp->addUnit( $newUnit );
    }
    return $comp;
  }
}