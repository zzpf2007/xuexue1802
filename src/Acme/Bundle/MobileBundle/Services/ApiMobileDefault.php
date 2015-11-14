<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;

class ApiMobileDefault extends ApiMobileMode
{
  protected function getUrl()
  {
    // return $this->options['ABLE_SKY_URL'];
    return '';
  }

  public function getResponse()
  {
    // $testUrl = $this->getTestUrl();
    // return $this->restClient->get( $testUrl );
    return '';
  }
}