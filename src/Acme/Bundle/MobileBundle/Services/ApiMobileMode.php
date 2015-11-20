<?php

namespace Acme\Bundle\MobileBundle\Services;

abstract class ApiMobileMode
{
  protected $options;
  protected $htmlNoteOptions;
  protected $resultOptions;
  protected $container; 
  protected $restClient;
  protected $itemId;

  public function __construct( $container, $options, $itemId = null )
  {
    $this->options = $options;
    $this->itemId = $itemId;
    $this->init( $container );
  }

  private function init( $container )
  {
    $this->container = $container;

    if (!$this->container->has('ci.restclient')) {
        throw new \LogicException('The Ci/RestClientBundle is not registered in your application.');
    }

    $this->restClient = $this->container->get('ci.restclient');

    $this->htmlNoteOptions = $this->container->getParameter('api_school.html_nodes');
    $this->resultOptions = $this->container->getParameter('api_school.result_message');

    return $this;
  }

  protected abstract function getUrl();

  abstract function getResponse();
}