<?php

namespace Acme\Bundle\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
  /**
   * @Route("/home/{name}/{itemId}", defaults = {"name" = null, "itemId" = null}))
   */
  public function indexAction($name, $itemId)
  {
    $apiMobile = $this->get('my_service.api.mobile.factory')->getInstance( $this->container, $name, $itemId );
    $content = $apiMobile->getResponse();

    return new Response( $content );
 }

  private function getHomeBanner()
  {
    $result = '{"code":0,"message":"succeed!",
                "result":{
                  "list":[
                    {"id":1,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-1.jpg"},
                    {"id":2,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-2.jpg"},
                    {"id":3,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-3.jpg"},
                    {"id":4,"url":"http://www.xuekaotong.cn/assets/images/mobile/banner/banner-4.jpg"}
                  ]
                }
               }';
    return $result;
  }

  private function getHomeCategory()
  {
    $result = '{"code":0,"message":"succeed!",
                "result":{
                  "list":[
                    {"id":1,"title":"注册建造师","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":2,"title":"造价工程师","icon":"null","category_id":"207512","click_url":"http://www.xuekaotong.cn/api/school/categories/207512"},
                    {"id":3,"title":"注册结构师","icon":"null","category_id":"209731","click_url":"http://www.xuekaotong.cn/api/school/categories/209731"},
                    {"id":4,"title":"注册监理师","icon":"null","category_id":"209734","click_url":"http://www.xuekaotong.cn/api/school/categories/209734"},
                    {"id":5,"title":"注册消防师","icon":"null","category_id":"209747","click_url":"http://www.xuekaotong.cn/api/school/categories/209747"},
                    {"id":6,"title":"注册电气师","icon":"null","category_id":"209749","click_url":"http://www.xuekaotong.cn/api/school/categories/209749"},
                    {"id":7,"title":"物业管理师","icon":"null","category_id":"209904","click_url":"http://www.xuekaotong.cn/api/school/categories/209904"},
                    {"id":8,"title":"更多..","icon":"null","category_id":"null","click_url":"null"}
                  ]
                }
               }';
    return $result;
  }

  private function getHomeCourses()
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

}
