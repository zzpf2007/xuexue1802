<?php

namespace AppBundle\Utility\WebApi\WebResponse;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Category;

abstract class WebResponseMode
{
  // protected $restClient;

  // public function __construct( $restClient )
  // {
  //   $this->restClient = $restClient;
  // }
  
  abstract function getResponse();
}
