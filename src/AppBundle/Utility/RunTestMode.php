<?php

namespace AppBundle\Utility;

abstract class RunTestMode {
  protected $restClient;

  public function __construct($restClient)
  {
    $this->restClient = $restClient;
  }

  abstract function runTest();
}
