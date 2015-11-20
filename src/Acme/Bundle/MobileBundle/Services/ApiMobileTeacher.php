<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\WebUtility\WebAuto;

class ApiMobileTeacher extends ApiMobileMode
{
  protected function getUrl()
  {
    $url = $this->options['ABLE_SKY_TEACHERS_URL'];
    if ( $this->itemId )
      $url = $this->options['ABLE_SKY_TEACHER_ID_URL'] . $this->itemId;

    return $url;
  }

  public function getResponse()
  {
    $testUrl = $this->getUrl();
    $response = $this->restClient->get( $testUrl );

    $content = '';

    if ( isset( $this->itemId ) ) {
      $content = $this->buildSingleJson( $response->getContent() );
    } else {
      $content = $this->buildListJson( $response->getContent() );
    }

    return $content;
  }

  private function buildSingleJson( $content )
  {
    $xpathObj = WebAuto::buildHTMLDocXPath( $content );

    $name = $this->getTeacherName( $xpathObj );
    $photo = $this->getTeacherImage( $xpathObj );
    $detailedList = $this->getTeacherDetails( $xpathObj );

    $coursesImageList = $this->getCoursesImage( $xpathObj );
    $coursesTitleList = $this->getCoursesTitle( $xpathObj );
    $coursesIdList = $this->getCoursesId( $xpathObj );

    $result = $this->outputTeacherDetailsJson( $name, $photo, $detailedList, $coursesImageList, $coursesTitleList, $coursesIdList );

    return $result;
  }

  private function outputTeacherDetailsJson( $name, $photo, $detailedList, $coursesImageList, $coursesTitleList, $coursesIdList )
  {
    $retStart = '{' . $this->resultOptions['SUCCEED'] . ',';

    list($major, $item, $description) = $detailedList;
    
    $description = WebJson::strRemoveSpace($description);

    // $string = htmlentities($description, null, 'utf-8');
    // $content = str_replace("&nbsp;", "", $string);
    // $content = html_entity_decode($content);

    $categoriesJson = $this->outputCategoriesJson( $coursesImageList, $coursesTitleList, $coursesIdList );

    $content = sprintf('"result":{"id":"%s","name":"%s","work_exp":"6","major":"%s","photo":"%s","valid":"true","description":"%s",%s}',
                        $this->itemId, $name, $major, $photo, $description, $categoriesJson
                      );

    $retEnd = '}';

    return $retStart . $content . $retEnd;
  }

  private function outputCategoriesJson( $coursesImageList, $coursesTitleList, $coursesIdList )
  {
    $retJson = '"categories":{"list":[';
    $content = '';

    for ( $i = 0; $i < count( $coursesImageList ); $i++ ) {
      if ( !isset( $coursesTitleList[$i] ) ) $coursesTitleList[$i] = 'null';
      if ( !isset( $coursesIdList[$i] ) ) $coursesIdList[$i] = 'null';
      $image = $coursesImageList[$i];
      $title = $coursesTitleList[$i];
      $idLink = $coursesIdList[$i];
      $id = '';

      if ( preg_match('/^.*detail_([0-9]*)$/', $idLink, $matches ) ) {
        $id = $matches[1];
      }
      // "title":"一级建造师","duration":"90分50秒","play_count":800
      $content = $content . sprintf('{"id":"%s","title":"%s","photo":"%s"},', $id, $title, $image);
    }
    $content = rtrim( trim($content, ',') );

    $retJson = $retJson . $content . ']}';    
    return $retJson;
  }

  private function getCoursesImage( $xpathObj )
  {
    $xpath = $this->htmlNoteOptions['TEACHER_COURSES_IMAGE'];
    // echo $xpath = '//xhtml:div[@class="teacher-course-items"]';
    // echo $xpath = '//xhtml:div[@class="teacher-connect-course"]';
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $xpath ); 

    $retArray = array();
    foreach ($nodes as $node) {
      $retArray[] = $node->nodeValue;
    }

    return $retArray;
  }

  private function getCoursesTitle( $xpathObj )
  {
    $nameXPath = $this->htmlNoteOptions['TEACHER_COURSES_TITLE'];
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $nameXPath ); 

    $retArray = array();
    foreach ($nodes as $node) {
      $retArray[] = $node->nodeValue;
    }

    return $retArray;
  }

  private function getCoursesId( $xpathObj )
  {
    $nameXPath = $this->htmlNoteOptions['TEACHER_COURSES_URLS'];
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $nameXPath ); 

    $retArray = array();
    foreach ($nodes as $node) {
      $retArray[] = $node->nodeValue;
    }

    return $retArray;
  }


  private function getTeacherName( $xpathObj )
  {
    $nameXPath = $this->htmlNoteOptions['TEACHER_NAME'];
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $nameXPath ); 
    $name = '';
    foreach ($nodes as $node) {
      $name = $node->nodeValue;
    }

    return $name;
  }

  private function getTeacherImage( $xpathObj )
  {
    $result = '';
    $nameXPath = $this->htmlNoteOptions['TEACHER_IMAGE'];
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $nameXPath ); 
    $name = '';
    foreach ($nodes as $node) {
      $result = $node->nodeValue;
    }

    return $result;
  }

  private function getTeacherDetails( $xpathObj )
  {
    $nameXPath = $this->htmlNoteOptions['TEACHER_DETAILS'];
    $nodes = WebAuto::getHTMLDocNodesByPath( $xpathObj, $nameXPath ); 

    $retArray = array();
    foreach ($nodes as $node) {
      $retArray[] = $node->nodeValue;
    }

    return $retArray;
  }

  private function buildListJson( $content )
  {
    $json = WebJson::stringToJson($content);
    if ( !is_object($json) && !isset($json->{'result'}) ) return $json;
    $result = $json->{'result'};

    if ( !isset($result->{'list'}) ) return $json;
    $resultList = $result->{'list'};

    $resultMessage = $this->resultOptions['SUCCEED'];
    $retResult = '{' . $resultMessage . ',"result":{"list":[';

    foreach ($resultList as $item) {
      $id = $item->{'id'};
      $name = trim( $item->{'name'} );
      $work_exp = 'null';
      $major = trim( $item->{'expertSubject'} );
      $photo = trim( $item->{'teacherPhotoPath'} );
      $valid = 'null';
      // $description = trim( $item->{'description'} );

      // $itemJson = sprintf('{"id":"%s","name":"%s","work_exp":"%s","major":"%s","photo":"%s","valid":"%s","description":"%s"},', $id,$name,$work_exp,$major,$photo,$valid,$description);
      $itemJson = sprintf('{"id":"%s","name":"%s","work_exp":"%s","major":"%s","photo":"%s","valid":"%s"},',$id,$name,$work_exp,$major,$photo,$valid);
      $retResult = $retResult . $itemJson;

      // $itemArray = array('id' => $id, 'name' => $name, 'work_exp' => $work_exp, 'major' => $major, 'photo' => $photo, 'valid' => $valid, 'description' => $description );
    }

    $retResult = rtrim(trim($retResult), ',') . ']}}';
    return $retResult;
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