<?php

namespace AppBundle\Utility\Check;

class CheckData {
  public static function dateExpired( $timestamp ) {
    $expired = false;
    if ( $timestamp ) {
      $timenow = time();

      // 20 mins
      $timeInterval = 60 * 15;
      // $timeInterval = 20;
      $diff = $timenow - $timestamp->getTimestamp();
      if ( $diff > $timeInterval ){
        $expired = true;
      }
    } else {
      $expired = true;
    }

    return $expired;
  }
}

