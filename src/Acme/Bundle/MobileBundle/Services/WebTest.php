<?php

namespace Acme\Bundle\MobileBundle\Services;

class WebTest 
{
  private $options;

  public function __construct( $options )
  {
    $this->options = $options;
  }

  public function getUrl()
  {
    return $this->options['ABLE_SKY_MOBILE_URL'];
  }
}