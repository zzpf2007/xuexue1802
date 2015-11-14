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
                    {"id":1,"url":"http://pic.58pic.com/58pic/14/13/09/64b58PICYzy_1024.jpg"},
                    {"id":2,"url":"http://pic2.ooopic.com/10/57/50/93b1OOOPIC4d.jpg"},
                    {"id":3,"url":"http://pic.58pic.com/58pic/14/13/09/64b58PICYzy_1024.jpg"},
                    {"id":4,"url":"http://pic2.ooopic.com/10/57/50/93b1OOOPIC4d.jpg"}
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
                    {"id":1,"title":"注册建造师1","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":2,"title":"注册建造师2","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":3,"title":"注册建造师3","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":4,"title":"注册建造师4","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":5,"title":"注册建造师5","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":6,"title":"注册建造师6","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
                    {"id":7,"title":"注册建造师7","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470"},
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
                    {"id":1,"title":"一级建造师1","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":2,"title":"一级建造师2","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":3,"title":"一级建造师3","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":4,"title":"一级建造师4","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":5,"title":"一级建造师5","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":6,"title":"一级建造师6","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":7,"title":"一级建造师7","icon":"null","category_id":"207470","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘霖"},
                    {"id":8,"title":"更多..","icon":"null","category_id":"null","click_url":"null"}
                  ]
                }
               }';
    return $result;
  }

}
