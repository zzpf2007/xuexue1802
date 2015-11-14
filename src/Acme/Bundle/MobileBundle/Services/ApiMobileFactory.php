<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileTeacher,
    Acme\Bundle\MobileBundle\Services\ApiMobileDefault;


class ApiMobileFactory
{
  private $options;

  public function __construct( $options ) {
    $this->options = $options;
  }

  public function getInstance( $container, $name, $itemId = null ) {
    $options = $this->options;
    $apiObj;
    switch ( $name ) {
      case ( 'teachers' ):
        $apiObj = new ApiMobileTeacher($container, $options, $itemId); break;
      default:
        $apiObj = new ApiMobileDefault($container, $options, $itemId);
    }
    return $apiObj;
  }
}