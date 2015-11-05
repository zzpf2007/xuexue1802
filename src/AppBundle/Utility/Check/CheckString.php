<?php

namespace AppBundle\Utility\Check;

class CheckString {
  static function check( $str ) {
    return !is_null( $str ) ? $str : 'Empty return value string!';
  }
}

