<?php

namespace AppBundle\Utility\Check;

class CheckData {
  public static function dateExpired( $timestamp ) {
    $expired = true;
    
    if ( $timestamp ) {
      $timenow = time();

      // 20 mins
      $timeInterval = 60 * 60 * 4;
      // $timeInterval = 20;
      $diff = $timenow - $timestamp->getTimestamp();
      if ( $diff < $timeInterval ){
        $expired = false;
      }
    }

    return $expired;
  }
}

