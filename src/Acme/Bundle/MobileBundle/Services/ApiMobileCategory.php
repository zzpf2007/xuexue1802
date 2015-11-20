<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class ApiMobileCategory extends ApiMobileMode
{
  public function getResponse()
  {
    $content = $this->getHomeContent();
    // $content = WebJson::strRemoveSpace($content);
    return $content;
  }

  private function getHomeContent()
  {
    $result = '{"code":0,"message":"succeed!",';
    $result .= '"result":{';
    $result .= '"list":[';
    $result .= '{"id":1,"title":"注册建造师","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},';
    $result .= '{"id":2,"title":"造价工程师","icon":"null","category_id":"207512","click_url":"http://www.xuekaotong.cn/api/school/categories/207512"},';
    $result .= '{"id":3,"title":"注册结构师","icon":"null","category_id":"209731","click_url":"http://www.xuekaotong.cn/api/school/categories/209731"},';
    $result .= '{"id":4,"title":"注册监理师","icon":"null","category_id":"209734","click_url":"http://www.xuekaotong.cn/api/school/categories/209734"},';
    $result .= '{"id":5,"title":"注册消防师","icon":"null","category_id":"209747","click_url":"http://www.xuekaotong.cn/api/school/categories/209747"},';
    $result .= '{"id":6,"title":"注册电气师","icon":"null","category_id":"209749","click_url":"http://www.xuekaotong.cn/api/school/categories/209749"},';
    $result .= '{"id":7,"title":"物业管理师","icon":"null","category_id":"209904","click_url":"http://www.xuekaotong.cn/api/school/categories/209904"},';
    $result .= '{"id":8,"title":"更多..","icon":"null","category_id":"null","click_url":"null"}';
    $result .= ']}}';

    return $result;
  }

  protected function getUrl()
  {
    return '';
  }

}