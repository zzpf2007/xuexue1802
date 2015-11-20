<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class ApiMobileCourse extends ApiMobileMode
{
  public function getResponse()
  {
    $content = $this->getHomeContent();
    $content = WebJson::strRemoveSpace($content);
    return $content;
  }

  private function getHomeContent()
  {
    $result = '{"code":0,"message":"succeed!",
                "result":{
                  "list":[
                    {"id":1,"title":"2015年一级建造师市政工程精讲课","icon":"null","category_id":"966796","click_url":"http://www.xuekaotong.cn/api/school/categories/966796","teacher":"甘 森"},
                    {"id":2,"title":"2015一建建筑实务真题解析","icon":"null","category_id":"973411","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"韩 雷"},
                    {"id":3,"title":"2014年真题一建市政肖国祥真题解析班01","icon":"null","category_id":"964807","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"肖国祥"},
                    {"id":4,"title":"一建建筑城镇道路基层施工","icon":"null","category_id":"966791","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","966791":"甘 森"},
                    {"id":5,"title":"2015一建建筑实务真题解析","icon":"null","category_id":"972741","click_url":"http://www.xuekaotong.cn/api/school/categories/972741","teacher":"韩 雷"},
                    {"id":6,"title":"2014年真题一建市政真题解析班","icon":"null","category_id":"966006","click_url":"http://www.xuekaotong.cn/api/school/categories/966006","teacher":"肖国祥"},
                    {"id":7,"title":"2015年一级建造师市政精选课程二建-市政-精讲班17","icon":"null","category_id":"967758","click_url":"http://www.xuekaotong.cn/api/school/categories/967758","teacher":"曹明铭"},
                    {"id":8,"title":"更多..","icon":"null","category_id":"null","click_url":"null"}
                  ]
                }
               }';
    return $result;
  }

  protected function getUrl()
  {
    return '';
  }

}