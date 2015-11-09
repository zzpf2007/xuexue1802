<?php

namespace AppBundle\Controller\Utility;

// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use AppBundle\Utility\WebApi\WebApiFactory;
// use AppBundle\Utility\WebApi\WebApiCategory;
// use AppBundle\Utility\Check\CheckString;
// use AppBundle\Entity\Category;
// use AppBundle\Utility\Check\CheckData;
// use AppBundle\Utility\WebUtility\WebAuto;

class WebUtility extends Controller
{
    public static function findCourse( $course_id = null )
    {
      $courseRepo = $this->getDoctrine()
                         ->getRepository('AppBundle:Course');
      $course = null;
      if ( $course_id ) {        
        $course = $courseRepo->findOneBy( array('ablesky_id' => $course_id), array('updated' => 'DESC') );
        if ( !$course ) {
          $course = new Course();
          $course->setAbleskyId($categoryId);
        }
      }

      return $course;
    }

    public static function handleCourseResponse( $course_id = null )
    {
      $course = WebUtility::findCourse( $course_id );
      $restClient = $this->container->get('ci.restclient');

      $retResult = '{ "Result" : [';

      if ( $course ) {
        $url = 'http://xkt.jzcnw.com/kecheng/detail_' . $course->getAbleskyId();
        $response = $restClient->get($url);
        $content = $response->getContent();
        $opts = array('output-xhtml' => true,
                      'numeric-entities' => true);
        $xml = tidy_repair_string($content, $opts, 'utf8');
        $doc = new \DOMDocument();
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
        }

        foreach ($course_ids as $node) {
            $link = $node->nodeValue;
            $listId[] = $link;
        }

        $listRet = array();

        for ( $i = 0; $i < count( $listTitle ); $i++ ) {
            $ret = '{ "id" : "' . $listId[$i] . '", "title" : "' . $listTitle[$i] . '"},';
            $retResult = $retResult . $ret;
        }        
      }
      $retResult = rtrim(trim($retResult), ',') . ' ]}';
      return $retResult;
    }
}
