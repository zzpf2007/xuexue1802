<?php

namespace Acme\Bundle\MobileBundle\Services;

use Acme\Bundle\MobileBundle\Services\ApiMobileMode;
use AppBundle\Utility\WebUtility\WebJson;

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
    return $content;
    // return 'Single result! :' . $testUrl = $this->getUrl();
  }

  private function buildListJson( $content )
  {
    $json = WebJson::stringToJson($content);
    if ( !is_object($json) && !isset($json->{'result'}) ) return $json;    
    $result = $json->{'result'};

    if ( !isset($result->{'list'}) ) return $json;
    $resultList = $result->{'list'};

    $retResult = '{"code":0,"message":"succeed!","result":{"list":[';

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