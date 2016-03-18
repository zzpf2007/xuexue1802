<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class ApiMobileCourse extends ApiMobileMode
{
  public function getResponse()
  {
    // $content = $this->getHomeContent();
    // $content = WebJson::strRemoveSpace($content);

    $content = $this->getHomeCourse();
    return $content;
  }

  private function getHomeCourse()
  {
    $result = '{"code":0,"message":"succeed!","result":{"list":[
              ';

    $em = $this->container->get('doctrine')->getManager();
    $repo = $em->getRepository('AppBundle:Course');
    $courses= $repo->findBy(array(), null, 70, null);

    $courselist = '';
    foreach ($courses as $index => $course) {
      // $result .= $index . ',';
      $id = $course->getAbleskyId();
      $title = $course->getTitle();
      $teacher = "";
      if ( $course->getTeacher() )
        $teacher = $course->getTeacher()->getName();      
      $photo = $course->getPhoto();
      $tcUrl = $course->getTcVideoUrl();

      $type = "0";

      if ( $index < 8 ) {
        $type = "0";
        $courselist .= sprintf('{"id":"%s","title":"%s","teacher":"%s","photo":"%s","type":"%s","tcVideoUrl":"%s"},', $id, $title, $teacher, $photo, $type, $tcUrl);
      }

      if ( $index > 8 && $index < 16 ) {
        $type = "1";
        $courselist .= sprintf('{"id":"%s","title":"%s","teacher":"%s","photo":"%s","type":"%s","tcVideoUrl":"%s"},', $id, $title, $teacher, $photo, $type, $tcUrl);
      }

      if ( $index > 16 && $index < 25 ) {
        $type = "2";
        $courselist .= sprintf('{"id":"%s","title":"%s","teacher":"%s","photo":"%s","type":"%s","tcVideoUrl":"%s"},', $id, $title, $teacher, $photo, $type, $tcUrl);
      }
    }

    $result .=  rtrim($courselist, ",") . ']}}';
    return $result;
  }

  private function getHomeContent()
  {
    $result = '{"code":0,"message":"succeed!",
                "result":{
                  "list":[
                    {"id":1,"title":"2015年一级建造师市政工程精讲课","icon":"null","category_id":"966796","click_url":"http://www.xuekaotong.cn/api/school/categories/966796","teacher":"甘 森","photo":"http://pic2.ablesky.cn/content/pic/coursecontentphoto/2015/10/30/13012e32-eb76-4f12-9a04-1f3a847e95a9.jpg"},
                    {"id":2,"title":"2015一建建筑实务真题解析","icon":"null","category_id":"973411","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"韩 雷","photo":"http://pic6.ablesky.cn/content/pic/coursecontentphoto/2015/11/26/282c6d9d-d670-4eab-a912-d3043bc50c7f.jpg"},
                    {"id":3,"title":"2014年真题一建市政肖国祥真题解析班01","icon":"null","category_id":"964807","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"肖国祥","photo":"http://pic6.ablesky.cn/content/pic/coursephoto/2015/10/30/f665b70b-b42f-421f-80db-780415abb536.jpg"},
                    {"id":4,"title":"一建建筑城镇道路基层施工","icon":"null","category_id":"966791","click_url":"http://www.xuekaotong.cn/api/school/categories/207470","teacher":"甘 森","photo":"http://pic5.ablesky.cn/content/pic/coursephoto/2015/10/30/6703a013-a84e-49cf-b887-982ac2ecb23a.jpg"},
                    {"id":5,"title":"2015一建建筑实务真题解析","icon":"null","category_id":"972741","click_url":"http://www.xuekaotong.cn/api/school/categories/972741","teacher":"韩 雷","photo":"http://pic1.ablesky.cn/content/pic/coursecontentphoto/2015/11/24/780f671d-7036-4a6c-b84e-85b8f22c8a56.jpg"},
                    {"id":6,"title":"2014年真题一建市政真题解析班","icon":"null","category_id":"966006","click_url":"http://www.xuekaotong.cn/api/school/categories/966006","teacher":"肖国祥","photo":"http://pic3.ablesky.cn/content/pic/coursephoto/2015/10/30/f0d7891d-bb24-4183-a8fc-74b343cfc5d0.jpg"},
                    {"id":7,"title":"2015年一级建造师市政精选课程二建-市政-精讲班17","icon":"null","category_id":"967758","click_url":"http://www.xuekaotong.cn/api/school/categories/967758","teacher":"曹明铭","photo":"http://pic3.ablesky.cn/content/pic/coursephoto/2015/11/04/0fbd45ca-09a1-4566-96dd-c3bbfa464945.jpg"},
                    {"id":8,"title":"更多..","icon":"null","category_id":"null","click_url":"null", "teacher":"null"}
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