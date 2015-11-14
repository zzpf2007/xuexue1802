<?php

namespace Acme\Bundle\MobileBundle\Services;

abstract class ApiMobileMode
{
  protected $options;
  protected $container; 
  protected $restClient;

  public function __construct( $container, $options, $itemId = null )
  {
    $this->options = $options;
    $this->init( $container );
  }

  private function init( $container )
  {
    $this->container = $container;

    if (!$this->container->has('ci.restclient')) {
        throw new \LogicException('The Ci/RestClientBundle is not registered in your application.');
    }

    $this->restClient = $this->container->get('ci.restclient');
    return $this;
  }

  protected abstract function getUrl();

  abstract function getResponse();
}