<?php

namespace AppBundle\Utility\WebTest;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\RunTestMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;

class WebResponseTest extends RunTestMode {
  function runTest() {
    // $ret = $this->getTest();
    // $ret = $this->getTest02();
    // $ret = $this->getTest03();
    $ret = $this->getTest04();
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

  function getTest04() {
    $restClient = $this->restClient; 
    $url = 'http://xkt.jzcnw.com/kecheng/detail_966796';
    $response = $restClient->get($url);
    $content = $response->getContent();

    // list($page,$pageInfo) = $this->load_with_curl($url);

    $opts = array('output-xhtml' => true,
            'numeric-entities' => true);
    $xml = tidy_repair_string($content, $opts, 'utf8');
    $doc = new \DOMDocument();
    // $doc->setEncoding("UTF8");
    $doc->loadXML($xml);
    $xpath = new \DOMXPath($doc);
    $xpath->registerNamespace('xhtml','http://www.w3.org/1999/xhtml');
    $titles = $xpath->query('//xhtml:span[@class="course-tit"]');
    $course_ids = $xpath->query('//xhtml:a/@data-coursecontentid');

    $listTitle = array();
    $listId = array();

    foreach ($titles as $node) {
        $link = $node->nodeValue;
        $listTitle[] = $link;
        // print $link . '||';
    }

    foreach ($course_ids as $node) {
        $link = $node->nodeValue;
        $listId[] = $link;
        // print $link . '||';
    }

    $listRet = array();
    $retResult = '{ "Result" : [';
    // $retResult = '';

    for ( $i = 0; $i < count( $listTitle ); $i++ ) {
        // print $listId[$i];
        // $id = $listId[$i]; $title = $listTitle[$i];
        // $listTemp = array( "id" => $listId[$i], "title" => $listTitle[$i] );
        // print $listTitle[$i];
        // $listRet[] = $listTemp;
        $ret = '{ "id" : "' . $listId[$i] . '", "title" : "' . $listTitle[$i] . '"},';
        $retResult = $retResult . $ret;
    }

    $retResult = rtrim(trim($retResult), ',') . ' ]}';
    return $retResult;

    // return json_encode($listRet);

    // $doc = new \DOMDocument();
    // $opts = array('output-xhtml' => true,
    //                 // Prevent DOMDocument from being confused about entities
    //                 'numeric-entities' => true);
    // $doc->loadXML(tidy_repair_string( utf8_encode($content), $opts ));
    // // $doc->loadXML( $content );
    // $xpath = new \DOMXPath($doc);
    // $body = $doc->getElementsByTagName('body')->item(0);

    // $ret = "";

    // foreach ($xpath->query("descendant-or-self::text()", $body) as $textNode) {
    //     $ret = $ret . $textNode->wholeText;
    //   }

    // return $ret;
  }

    function load_with_curl($url, $method = 'GET') {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'GET') {
            curl_setopt($c,CURLOPT_FOLLOWLOCATION, true);
        }
        else if ($method == 'HEAD') {
            curl_setopt($c, CURLOPT_NOBODY, true);
            curl_setopt($c, CURLOPT_HEADER, true);
        }
        $response = curl_exec($c);
        return array($response, curl_getinfo($c));
    }
}
