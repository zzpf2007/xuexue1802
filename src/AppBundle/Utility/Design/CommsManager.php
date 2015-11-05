<?php

namespace AppBundle\Utility\Design;

class CommsManager
{
  const BLOGGS = 1;
  const MEGA = 2;
  private $mode = 1;

  function __construct( $mode )
  {
    $this->mode = $mode;
  }

  function getApptEncoder()
  {
    switch ( $this->mode )
    {
      case ( self::MEGA ):
        return new MegaApptEncoder();
      default:
        return new BloggsApptEncoder();
    }    
  }
}

abstract class ApptEncoder
{
  abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
  function encode()
  {
    return "Appointment data encoded in BloggsCal format \n";
  }
}

class MegaApptEncoder extends ApptEncoder
{
  function encode()
  {
    return "Appointment data encoded in Mega format \n";
  }
}
