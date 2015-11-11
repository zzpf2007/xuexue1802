<?php

namespace AppBundle\Utility\WebApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;
use AppBundle\Utility\WebApi\WebResponse\CategoryRootResponse;
use AppBundle\Utility\WebApi\WebResponse\CategoryChildResponse;

class WebApiCategory extends WebApiMode
{
  private $webResponse;

  public function __construct( $container, $itemId = null ) 
  {
    parent::__construct($container);
    $this->webResponse = $this->getResponseObject( $itemId );
  }

  private function getResponseObject( $itemId = null )
  {
    $container = $this->container;
    $webResponse = new CategoryRootResponse( $container );
    if ( $itemId ) {
      $webResponse = new CategoryChildResponse( $container, $itemId );
    }
    return $webResponse;
  }

  public function getResult() 
  {
    return $this->webResponse->getResponse();
  }
}
