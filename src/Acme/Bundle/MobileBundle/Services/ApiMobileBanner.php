<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class ApiMobileBanner extends ApiMobileMode
{
  public function getResponse()
  {
    $content = $this->getHomeBanner();
    return $content;
  }

  private function getHomeBanner()
  {
    $result = '{"code":0,"message":"succeed!","result":{"list":[{"id":1,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-1.jpg"},{"id":2,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-2.jpg"},{"id":3,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-3.jpg"},{"id":4,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-4.jpg"}]}}';
    return $result;
  }

  protected function getUrl()
  {
    return '';
  }

}