<?php

namespace AppBundle\Utility\WebApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Utility\WebApi\WebApiMode;
use AppBundle\Utility\WebUtility\WebAuto;
use AppBundle\Utility\WebUtility\WebJson;
use AppBundle\Utility\Check\CheckData;
use AppBundle\Entity\Course;

class WebApiCourse extends WebApiMode
{
  private $course;

  public function __construct( $container, $itemId = null ) 
  {
    parent::__construct($container);
    $this->course = $this->getCourse($itemId);
  }

  public function getResult() 
  {
    $retResult = "";
    if ( !$this->course ) { 
      $retResult = sprintf('{ "error" : "1", "message" : "empty course id !" }');
    } else {
      $retResult = $this->handleCourseRequest();
    }
    return $retResult;
  }

  private function handleCourseRequest()
  {
    $retResult = '';
    $timeExpired = CheckData::dateExpired( $this->course->getUpdatedAt() );

    // $timeExpired = true;

    if ( $this->course && $timeExpired ) {
      $retResult = $this->getAbleSkyResponse();
    } else if ( $this->course ) {
      $retResult = $this->course->getMobileJson();
    }

    return $retResult;
  }

  private function getAbleSkyResponse()
  {
    $restClient = $this->container->get('ci.restclient');
    $url = $this->buildURL();
    $response = $restClient->get($url);
    $content = $response->getContent();
    // var_dump($content);
    $opts = array('output-xhtml' => true,
                  'numeric-entities' => true);
    $xml = tidy_repair_string($content, $opts, 'utf8');
    $doc = new \DOMDocument();
    $doc->loadXML($xml);
    $xpath = new \DOMXPath($doc);
    $xpath->registerNamespace('xhtml','http://www.w3.org/1999/xhtml');

    $titles = $xpath->query('//xhtml:span[@class="course-tit"]');
    // $courseIds = $xpath->query('//xhtml:a[@data-coursecontentid]');
    $courseIds = $xpath->query('//xhtml:a/@data-coursecontentid');
    // $courseIds = $xpath->query('//xhtml:a[@class="study-start"]');
    
    // var_dump($courseIds);
    // print $courseIds;
     
    $listId = $this->getNodeList($courseIds);
    $listTitle = $this->getNodeList($titles);

    $retResult = $this->buildMobileJson( $listId, $listTitle );    
    $this->saveCourse($retResult);

    return $retResult;
  }

  private function getNodeList( $listNodes )
  {
    $listResult = array();
    foreach ($listNodes as $node) {
      // print $node->nodeValue;
      $listResult[] = $node->nodeValue;
    }
    return $listResult;
  }

  private function buildMobileJson( $listId, $listTitle) 
  {
    $retResult = '{ "result" : [';
    for ( $i = 0; $i < count( $listTitle ); $i++ ) {
      if ( !isset( $listId[$i] ) ) $listId[$i] = 'null';
      $title = $listTitle[$i];
      $title = WebJson::strRemoveSpace($title);
      $ret = sprintf( '{ "id" : "%s", "title" : "%s"},', $listId[$i], $title);
      $retResult = $retResult . $ret;
    }
    return $retResult = rtrim(trim($retResult), ',') . ' ]}';
  }

  private function getCourse( $courseId = null)
  {
    $courseRepo = $this->getDoctrine()
                       ->getRepository('AppBundle:Course');

    $course = null;
    if ( $courseId ) {        
      $course = $courseRepo->findOneBy( array('ablesky_id' => $courseId), array('updatedAt' => 'DESC') );
      if ( !$course ) {
        $course = new Course();
        $course->setAbleskyId($courseId);
      }
    }

    return $course;
  }

  private function buildURL()
  {
    return sprintf('http://www.ablesky.com/kecheng/detail_%s', $this->course->getAbleskyId());
    
    // return sprintf('http://xuekaotong.net/kecheng/detail_%s', $this->course->getAbleskyId());
  }

  private function saveCourse($mobileJson)
  {
    $this->course->setRawJson('default');
    $this->course->setMobileJson($mobileJson);
    $this->course->setMd5('default');
    // $this->course->setType('default');
    $this->course->setUpdatedAt( new \DateTime('now') );

    $em = $this->getDoctrine()->getManager();
    $em->persist($this->course);
    $em->flush();
  }
}
