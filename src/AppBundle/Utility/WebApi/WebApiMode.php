<?php

namespace AppBundle\Utility\WebApi;

abstract class WebApiMode {
  protected $restClient;
  protected $container;

  public function __construct( $container )
  {
    $this->container = $container;
  }

  abstract function getResult();

  protected function getDoctrine()
  {
    if (!$this->container->has('doctrine')) {
        throw new \LogicException('The DoctrineBundle is not registered in your application.');
    }

    return $this->container->get('doctrine');
  }
}
