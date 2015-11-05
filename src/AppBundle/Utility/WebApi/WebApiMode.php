<?php

namespace AppBundle\Utility\WebApi;

abstract class WebApiMode {
  protected $restClient;

  public function __construct($restClient)
  {
    $this->restClient = $restClient;
  }

  abstract function getResult();
}
