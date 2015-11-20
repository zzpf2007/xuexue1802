<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileTeacher;
use Acme\Bundle\MobileBundle\Services\ApiMobileBanner;
use Acme\Bundle\MobileBundle\Services\ApiMobileDefault;


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
      case ( 'banner' ):
        $apiObj = new ApiMobileBanner($container, $options, $itemId); break;
      case ( 'categories' ):
        $apiObj = new ApiMobileCategory($container, $options, $itemId); break;        
      case ( 'courses' ):
        $apiObj = new ApiMobileCourse($container, $options, $itemId); break;
      default:
        $apiObj = new ApiMobileDefault($container, $options, $itemId);
    }
    return $apiObj;
  }
}