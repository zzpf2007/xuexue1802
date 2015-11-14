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
    $result = '';
    switch ($name) {
      case 'banner':
        $result = $this->getHomeBanner();break;
      case 'categories':
        $result = $this->getHomeCategory();break;
      case 'courses':
        $result = $this->getHomeCourses();break;
      case 'teachers':
        $result = $this->getHomeTeachers( $itemId );break;
      default:
        $result = '';
        break;
    }
    return new Response( $result );
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

  private function getHomeTeachers( $itemId = null )
  {
    $result = '';
    if ( !$itemId ) {
      $result = '{"code":0,"message":"succeed!",
                  "result":{
                    "list":[
                      {"id":24476,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24477,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24478,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24479,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24470,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24471,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":24472,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg","valid":0},
                      {"id":0,"title":"更多..","work_exp":"null","major":"null","photo":"null","valid":0}
                    ]
                  }
                 }';
    } else {
      $result = '{"code":0,"message":"succeed!",
                    "result":{
                      "id":24476,"name":"甘霖","work_exp":"6","major":"一级建造师 造价工程师","photo":"http://pic6.ablesky.cn/content/pic/teacherphoto/2015/10/30/6780134d-7d02-46c4-a93c-6879ca94db00.jpg",
                      "valid":0,"description":"男，北京交通大学土建学院硕士，一级建造师，注册安全工程师。教学风格深受学员的喜爱。",
                      "categories":{"list": [
                        {"id":96706,"title":"一级建造师","duration":"90分50秒","play_count":800},
                        {"id":96706,"title":"一级建造师","duration":"90分50秒","play_count":800}
                      ]}
                    }
                  }';
    }

    return $result;
  }
}
