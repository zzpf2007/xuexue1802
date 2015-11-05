<?php

namespace AppBundle\Utility\WebTest;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\RunTestMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;

class WebResponseTest extends RunTestMode {
  function runTest() {
    $ret = $this->getTest();
    $ret = $this->getTest02();
    $ret = $this->getTest03();
    return $ret;
  }

  function getTest() {
    $restClient = $this->restClient;
    // $restClient = $this->container->get('ci.restclient');
    // $response = $restClient->get('http://www.baidu.com');
    $payloads = 'data=[orgId:123]&timestamp=123&accessToken=9876543';
    $data1 = array("orgId" => "100");
    // $post_data_01 = array( "data" => json_encode($data1), "timestamp" => "456789", "accessToken" => "987654321");
    $post_data_01 = array( "data" => "100", "timestamp" => "456789", "accessToken" => "987654321");
    // $post_data = array( "data" => "234", "timestamp" => "456789", "accessToken" => "987654321");
    // $post_data = json_encode($post_data);
    // $payloads = "{data:100, timestamp:456789, accessToken:987654321}";
    // $post_data = "{data:100, timestamp:456789, accessToken:987654321}";
    $post_data = http_build_query($post_data_01);
    // $post_data = json_encode($post_data);

    // $response = $restClient->post('http://accliapac1.cloudapp.net/api/user', $post_data, array(CURLOPT_CONNECTTIMEOUT => 30));
    $response = $restClient->post('http://accliapac1.cloudapp.net/api/user', $post_data, array(CURLOPT_CONNECTTIMEOUT => 30));
    $content = $response->getContent();
    $data = $content;
    // $data = join(' ', explode(' ', $content));

    // $json_data = json_decode($data);
    // $content = '{"data": 12345}';
    // $json_data = json_decode($content);
    // $data = $json_data->{'data'};//["data"];
    // $data = $post_data_01["data"];
    // $data = array_reverse ( explode(' ', $content) );
    // $data = implode(' ', $data);
    // $data = strtoupper($data);

    // return new Response("Content: " . $restClient);
    // $response->send();    
    return new Response("Content: " . $data );
  }

  function getTest02() {
    $restClient = $this->restClient;
    
    $payloads = WebAuto::webBuildParams();

    $response = $restClient->post('http://www.ablesky.com/organizationCategory.do?action=listOrgInteriorCategoryTree', $payloads, array(CURLOPT_CONNECTTIMEOUT => 30));

    $content = $response->getContent();
    $data = $content;
    return new Response("Content: " . $data );
  }

  function getTest03() {
    $restClient = $this->restClient;
    
    $url = WebAuto::webBuildURL();
    // $url = "/";
    // echo $url;
    // $url = 'http://xkt.jzcnw.com/wap/schoolCourseClassify?orgId=8778';
    // $url = 'http://xkt.jzcnw.com/organizationRedirect.do?action=viewCourseScheduleDetail&organizationId=8778';
    // $url = 'http://xkt.jzcnw.com/org/8778/course?organizationId=8778&categoryId=209776&serviceType=totalCourse&chargeType=0#toCourseList';

    $response = $restClient->get($url);

    $content = $response->getContent();
    // $content_json = WebJson::stringToJson($content);

    // $output01 = $content_json->{'result'}->{'list'}[0]->{'categoryName'} || "Failed";

    $data = $content;
    return $content;
    // $data = md5($content);
    // $data = $content_json->{'success'};
    // return new Response("Content: " . $data );
  }
}
