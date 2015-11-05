<?php

namespace AppBundle\Test\Utility\WebUtility;

// use Symfony\Component\Config\Definition\Exception\Exception;
// use Symfony\Component\HttpFoundation\Response;
// use AppBundle\Utility\RunTestMode;
use AppBundle\Utility\WebUtility\WebJson;

class WebJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testStringToJson()
    {
      $str = '{"data": 10}';

      $result = WebJson::stringToJson($str);
      $expect = '10';
      $result = $result->{'data'};
      $this->assertEquals( $expect, $result );
    }

    public function testJsonFile()
    {
      // $result = file_get_contents('/home/prodmgr/projects/ehelele1019/web/data.txt');

      $result = '{"message":"","success":true,"id":1,"result":
                  {"list": [ {"id":206295,"categoryName":"网校必修课","parentId":0,"children":{"list":[]},"categoryLevel":1}, 
                             {"id":207470,"categoryName":"一级建造师","parentId":0,"children":{"list":[
                                  {"id":209772,"categoryName":"公共科目","parentId":207470,"children":{"list":[]},"categoryLevel":2},
                                  {"id":209776,"categoryName":"专业管理与实务","parentId":207470,"children":{"list":[]},"categoryLevel":2}]}
                              ,"categoryLevel":1}
                           ]
                  }
                }';

      $ret = WebJson::parseJsonString($result);
      
      // print_r($ret);
    }
}