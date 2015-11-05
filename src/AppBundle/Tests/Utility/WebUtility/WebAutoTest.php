<?php

namespace AppBundle\Test\Utility\WebUtility;

use AppBundle\Utility\WebUtility\WebAuto;

class WebAutoTest extends \PHPUnit_Framework_TestCase
{
    public function testMakeUp()
    {
      // $result = WebAuto::makeUp();
      // $result = WebAuto::makePregSplit();
      $str = 'string  asd  ';
      $result = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
      // var_dump($result);
      // $this->assertEquals( $expect, $result );

      $content = '<strong>Lorem ipsum dolor</strong> sit <img src="test.png" />amet <span class="test" style="color:red">consec<i>tet</i>uer</span>.';
      $result = preg_split('/(<[^>]*[^\/]>)/i', $content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

      $html = '<link rel="icon" href="http://www.example.com/icon.gif"/>
               <link rel="prev" href="http://www.example.com/prev.xml"/>
               <link rel="next" href="http://www.example.com/next.xml"/>';

      preg_match_all('/rel="(prev|next)" href="([^"]*?)"/', $html, $result1);
      preg_match_all('/rel="(?:prev|next)" href="([^"]*?)"/', $html, $result2);
      // print_r($result1);
      // print_r($result2);
    }

    public function testEncode()
    {
      $str = "Shanghai";
      $result = md5($str);

      $orgParams = array();
      $orgParams['organizationId'] = 8778 ;
      $orgParams['optDate'] = 1446111630;

      $orgInfoWithKey = "8778" . "|" . "1446111630" . "|" . "E1F244781A9F4F42BD7E6ADB2316B0FF";
      $accessToken = md5($orgInfoWithKey);
      $orgParams['accessToken'] = $accessToken;

      $url = "http://www.ablesky.com/organizationCategory.do?action=listOrgInteriorCategoryTree&";
      $params = http_build_query($orgParams);
      // print_r($params);

      $url = $url . $params;

      // $time = time();
      // $date = date('Y-m-d H:i:s',$time);
      // var_dump($time);
      // var_dump($date);

      // print_r($url);
      // var_dump($url);

      // print_r($result);
    }
}