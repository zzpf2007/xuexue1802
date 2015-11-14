<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;

class ApiMobileTeacher extends ApiMobileMode
{
  protected function getUrl()
  {
    return $this->options['ABLE_SKY_TEACHER_URL'];
  }

  public function getResponse()
  {
    $testUrl = $this->getUrl();
    return $this->restClient->get( $testUrl );
  }
}